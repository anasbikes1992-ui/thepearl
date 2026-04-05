<?php

namespace App\Services\AI;

class PriceEstimatorService
{
    public function estimate(string $vertical, float $basePrice, string $district): array
    {
        $districtAdjustments = [
            'colombo' => 1.12,
            'gampaha' => 1.04,
            'kandy' => 1.06,
            'galle' => 1.08,
        ];

        $verticalAdjustments = [
            'property' => 1.10,
            'stays' => 1.06,
            'vehicles' => 1.05,
            'events' => 1.09,
            'sme_services' => 1.03,
            'tours' => 1.07,
            'home_beauty' => 1.02,
        ];

        $districtMultiplier = $districtAdjustments[strtolower($district)] ?? 1.00;
        $verticalMultiplier = $verticalAdjustments[$vertical] ?? 1.00;
        $suggested = round($basePrice * $districtMultiplier * $verticalMultiplier, 2);

        return [
            'min' => round($suggested * 0.9, 2),
            'recommended' => $suggested,
            'max' => round($suggested * 1.15, 2),
        ];
    }
}
