<?php

namespace App\Http\Controllers\Api\V1\Providers;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProviderOperatingSystemController extends Controller
{
    public function dashboard(Request $request): JsonResponse
    {
        $providerId = $request->user()->id;
        $provider = $request->user();

        $bookings = $provider->providerBookings();
        $bookingCount = $bookings->count();
        $gmv = (float) $bookings->sum('total_amount');
        $averageOrderValue = $bookingCount > 0 ? round($gmv / $bookingCount, 2) : 0.0;

        $avgRating = (float) Review::query()
            ->where('provider_user_id', $providerId)
            ->avg('rating');

        $openDisputes = Dispute::query()
            ->whereIn('booking_id', $bookings->select('id'))
            ->whereNotIn('status', ['resolved', 'closed'])
            ->count();

        $pricingHint = $avgRating >= 4.5 && $openDisputes === 0
            ? 'Strong trust and low disputes. Consider a +3% price test in high-demand windows.'
            : 'Maintain current price bands and prioritize service quality to improve conversion.';

        return response()->json([
            'data' => [
                'crm' => [
                    'repeat_customer_rate_estimate' => $bookingCount > 0 ? min(0.85, round(($bookingCount / max(1, $provider->customerBookings()->count() + 1)) * 0.5, 2)) : 0,
                    'active_pipeline' => $provider->providerBookings()->where('status', 'confirmed')->count(),
                ],
                'performance' => [
                    'bookings' => $bookingCount,
                    'gmv' => round($gmv, 2),
                    'average_order_value' => $averageOrderValue,
                    'avg_rating' => round($avgRating, 2),
                    'open_disputes' => $openDisputes,
                ],
                'automation' => [
                    'pricing_hint' => $pricingHint,
                    'dispute_prevention_hint' => $openDisputes > 0
                        ? 'Require OTP + QR proof for high-value bookings.'
                        : 'Current dispute trend is healthy. Keep objective completion proofs enabled.',
                    'marketing_hint' => 'Launch segmented campaigns for customers inactive for 30+ days.',
                ],
            ],
        ]);
    }
}
