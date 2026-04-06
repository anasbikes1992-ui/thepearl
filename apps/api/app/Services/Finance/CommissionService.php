<?php

namespace App\Services\Finance;

use App\Services\Admin\BusinessControlService;

class CommissionService
{
    public function __construct(private readonly ?BusinessControlService $businessControls = null)
    {
    }

    public function rateForVertical(string $vertical): float
    {
        $baseRate = match ($vertical) {
            'property', 'vehicles' => 0.12,
            'stays', 'events' => 0.10,
            'sme_services', 'tours', 'home_beauty' => 0.08,
            default => 0.10,
        };

        if (!$this->businessControls) {
            return $baseRate;
        }

        return $this->businessControls->commissionRateForVertical($vertical, $baseRate);
    }

    public function applySubscriptionDiscount(float $baseRate, float $discountRate): float
    {
        $effective = $baseRate - $discountRate;

        return max($effective, 0.04);
    }
}
