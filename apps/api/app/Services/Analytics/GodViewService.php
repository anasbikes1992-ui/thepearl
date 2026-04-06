<?php

namespace App\Services\Analytics;

use App\Models\Booking\Booking;
use App\Models\Dispute;
use App\Models\EscrowTransaction;
use App\Models\ProviderSubscription;
use App\Models\ReferralLedger;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class GodViewService
{
    public function build(): array
    {
        $now = now();
        $windowStart = $now->copy()->subDays(30);

        $gmv30d = (float) Booking::query()
            ->where('created_at', '>=', $windowStart)
            ->sum('total_amount');

        $take30d = (float) EscrowTransaction::query()
            ->where('created_at', '>=', $windowStart)
            ->sum('commission_amount');

        $takeToday = (float) EscrowTransaction::query()
            ->whereDate('created_at', $now->toDateString())
            ->sum('commission_amount');

        $avgDailyTake = $take30d / 30;
        $forecastNext30d = round($avgDailyTake * 30, 2);

        $subscriptionMrr = (float) ProviderSubscription::query()
            ->where('status', 'active')
            ->sum('monthly_price');

        $topVerticalTake = DB::table('escrow_transactions')
            ->join('bookings', 'bookings.id', '=', 'escrow_transactions.booking_id')
            ->join('listings', 'listings.id', '=', 'bookings.listing_id')
            ->selectRaw('listings.vertical as vertical, COALESCE(SUM(escrow_transactions.commission_amount), 0) as take_amount')
            ->groupBy('listings.vertical')
            ->orderByDesc('take_amount')
            ->limit(5)
            ->get();

        $referral = [
            'ledgers_total' => ReferralLedger::query()->count(),
            'points_referrer' => (int) ReferralLedger::query()->sum('points_awarded_referrer'),
            'points_referred' => (int) ReferralLedger::query()->sum('points_awarded_referred'),
        ];

        return [
            'revenue' => [
                'take_today' => round($takeToday, 2),
                'take_30d' => round($take30d, 2),
                'gmv_30d' => round($gmv30d, 2),
                'forecast_take_next_30d' => $forecastNext30d,
                'subscription_mrr' => round($subscriptionMrr, 2),
            ],
            'referrals' => $referral,
            'risk_and_quality' => [
                'open_disputes' => Dispute::query()->whereNotIn('status', ['resolved', 'closed'])->count(),
                'held_escrows' => EscrowTransaction::query()->where('status', 'held')->count(),
            ],
            'growth' => [
                'new_users_30d' => User::query()->where('created_at', '>=', $windowStart)->count(),
                'new_providers_30d' => User::query()->where('role', 'provider')->where('created_at', '>=', $windowStart)->count(),
            ],
            'top_vertical_take' => $topVerticalTake,
        ];
    }
}
