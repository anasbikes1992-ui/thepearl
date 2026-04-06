<?php

namespace App\Http\Controllers\Api\V1\Bookings;

use App\Enums\Booking\BookingStatus;
use App\Enums\EscrowStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bookings\StoreBookingRequest;
use App\Models\Booking\Booking;
use App\Models\EscrowTransaction;
use App\Models\Listing\Listing;
use App\Models\User;
use App\Services\EscrowCalculator;
use App\Services\Finance\CommissionService;
use App\Services\Loyalty\PearlPointsService;
use App\Services\Loyalty\ReferralService;
use App\Services\Platform\PlatformEventRecorder;
use Illuminate\Http\JsonResponse;

class BookingController extends Controller
{
    public function store(
        StoreBookingRequest $request,
        CommissionService $commissionService,
        EscrowCalculator $escrowCalculator,
        PlatformEventRecorder $recorder
    ): JsonResponse {
        $payload = $request->validated();

        $listing = Listing::query()->findOrFail($payload['listing_id']);
        $subtotal = (float) $listing->base_price * (float) ($payload['quantity'] ?? 1);
        $discountAmount = (float) ($payload['discount_amount'] ?? 0);
        $totalAmount = max($subtotal - $discountAmount, 0);

        $booking = Booking::query()->create([
            'listing_id' => $listing->id,
            'customer_id' => auth()->id(),
            'provider_id' => $listing->provider_id,
            'starts_at' => $payload['starts_at'],
            'ends_at' => $payload['ends_at'],
            'quantity' => (int) ($payload['quantity'] ?? 1),
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'currency' => $listing->currency,
            'status' => BookingStatus::Confirmed->value,
            'metadata' => $payload['metadata'] ?? null,
        ]);

        $commissionRate = $commissionService->rateForVertical($listing->vertical->value);
        $breakdown = $escrowCalculator->breakdown($totalAmount, $commissionRate, 0.015);

        $escrow = EscrowTransaction::query()->create([
            'booking_id' => $booking->id,
            'customer_id' => $booking->customer_id,
            'provider_id' => $booking->provider_id,
            'gross_amount' => $breakdown['gross_amount'],
            'commission_rate' => $commissionRate,
            'escrow_fee_rate' => 0.015,
            'commission_amount' => $breakdown['commission_amount'],
            'escrow_fee_amount' => $breakdown['escrow_fee_amount'],
            'provider_net_amount' => $breakdown['provider_net_amount'],
            'currency' => $listing->currency,
            'status' => EscrowStatus::Held,
            'auto_release_at' => now()->addHours(48),
        ]);

        $recorder->record('booking', $booking->id, 'booking.created', [
            'listing_id' => $listing->id,
            'customer_id' => $booking->customer_id,
            'provider_id' => $booking->provider_id,
            'total_amount' => $booking->total_amount,
        ]);

        $recorder->record('escrow_transaction', $escrow->id, 'escrow.held', [
            'booking_id' => $booking->id,
            'gross_amount' => $escrow->gross_amount,
        ]);

        return response()->json([
            'booking' => $booking,
            'escrow' => $escrow,
        ], 201);
    }

    public function complete(
        Booking $booking,
        PlatformEventRecorder $recorder,
        ReferralService $referralService,
        PearlPointsService $pointsService
    ): JsonResponse
    {
        $booking->update(['status' => BookingStatus::Completed->value]);

        $bookingEscrow = EscrowTransaction::query()->where('booking_id', $booking->id)->first();
        if ($bookingEscrow && $bookingEscrow->status === EscrowStatus::Held) {
            $bookingEscrow->update([
                'status' => EscrowStatus::Released,
                'released_at' => now(),
            ]);
        }

        $recorder->record('booking', $booking->id, 'booking.completed', [
            'provider_id' => $booking->provider_id,
        ]);

        $this->rewardReferralIfEligible($booking, $referralService, $pointsService, $recorder);

        return response()->json([
            'booking' => $booking->fresh(),
            'escrow' => $bookingEscrow?->fresh(),
        ]);
    }

    private function rewardReferralIfEligible(
        Booking $booking,
        ReferralService $referralService,
        PearlPointsService $pointsService,
        PlatformEventRecorder $recorder
    ): void {
        $referralCode = (string) ($booking->metadata['referral_code'] ?? '');
        if ($referralCode === '') {
            return;
        }

        $completedCount = Booking::query()
            ->where('customer_id', $booking->customer_id)
            ->where('status', BookingStatus::Completed->value)
            ->count();

        if ($completedCount !== 1) {
            return;
        }

        $customer = User::query()->find($booking->customer_id);
        $referrer = User::query()
            ->where('referral_code', $referralCode)
            ->where('id', '!=', $booking->customer_id)
            ->first();

        if (!$customer || !$referrer) {
            return;
        }

        $ledger = $referralService->rewardFirstTransaction($referrer, $customer, (string) $booking->id);

        $pointsService->award($referrer, (int) $ledger->points_awarded_referrer, 'referral_first_transaction_referrer');
        $pointsService->award($customer, (int) $ledger->points_awarded_referred, 'referral_first_transaction_referred');

        $recorder->record('booking', $booking->id, 'booking.referral_reward_awarded', [
            'referrer_user_id' => $referrer->id,
            'referred_user_id' => $customer->id,
            'points_referrer' => (int) $ledger->points_awarded_referrer,
            'points_referred' => (int) $ledger->points_awarded_referred,
            'ledger_id' => $ledger->id,
        ]);
    }
}
