<?php

namespace App\Services\Loyalty;

use App\Models\User;

class PersonalizedLoyaltyService
{
    public function nextBestReward(User $user): array
    {
        $points = (int) $user->pearl_points;
        $tier = match (true) {
            $points >= 5000 => 'gold',
            $points >= 1500 => 'silver',
            default => 'bronze',
        };

        $offer = match ($tier) {
            'gold' => '20% featured booking boost + concierge priority lane',
            'silver' => '10% booking credit on next cross-vertical order',
            default => 'Referral booster: invite a friend for 2x points',
        };

        return [
            'tier' => $tier,
            'recommended_offer' => $offer,
            'churn_risk' => $points < 300 ? 'high' : 'normal',
        ];
    }
}
