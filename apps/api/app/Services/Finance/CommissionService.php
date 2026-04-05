<?php

namespace App\Services\Finance;

class CommissionService
{
    public function rateForVertical(string $vertical): float
    {
        return match ($vertical) {
            'property', 'vehicles' => 0.12,
            'stays', 'events' => 0.10,
            'sme_services', 'tours', 'home_beauty' => 0.08,
            default => 0.10,
        };
    }

    public function applySubscriptionDiscount(float $baseRate, float $discountRate): float
    {
        $effective = $baseRate - $discountRate;

        return max($effective, 0.04);
    }
}
