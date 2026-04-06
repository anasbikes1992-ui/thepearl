<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ReferralLedger;
use App\Services\Loyalty\PersonalizedLoyaltyService;
use Illuminate\Http\JsonResponse;

class LoyaltyController extends Controller
{
    public function me(PersonalizedLoyaltyService $service): JsonResponse
    {
        $user = auth()->user();

        return response()->json([
            'points' => $user?->pearl_points ?? 0,
            'referral_code' => $user?->referral_code,
            'personalization' => $user ? $service->nextBestReward($user) : null,
        ]);
    }

    public function referrals(): JsonResponse
    {
        $user = auth()->user();

        $rows = ReferralLedger::query()
            ->where('referrer_user_id', $user->id)
            ->latest('created_at')
            ->limit(50)
            ->get();

        return response()->json([
            'summary' => [
                'referrals_count' => $rows->count(),
                'points_awarded_total' => (int) $rows->sum('points_awarded_referrer'),
            ],
            'entries' => $rows,
        ]);
    }
}
