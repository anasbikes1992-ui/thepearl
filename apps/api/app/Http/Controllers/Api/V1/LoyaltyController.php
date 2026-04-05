<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
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
}
