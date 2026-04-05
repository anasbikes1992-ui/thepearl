<?php

namespace App\Services\AI;

class PriceEstimatorService
{
    public function estimate(string $vertical, float $basePrice, string $district, array $context = []): array
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

        $demandMultiplier = $this->toRangeMultiplier((float) ($context['demand_index'] ?? 0.5), 0.90, 1.20);
        $seasonalityMultiplier = $this->seasonalityMultiplier((string) ($context['seasonality'] ?? 'normal'));
        $weatherMultiplier = $this->weatherMultiplier((string) ($context['weather'] ?? 'clear'));
        $eventMultiplier = $this->eventMultiplier((int) ($context['local_event_count'] ?? 0));
        $providerMultiplier = $this->providerMultiplier((float) ($context['provider_score'] ?? 70.0));

        $compositeMultiplier = $districtMultiplier
            * $verticalMultiplier
            * $demandMultiplier
            * $seasonalityMultiplier
            * $weatherMultiplier
            * $eventMultiplier
            * $providerMultiplier;

        $suggested = round($basePrice * $compositeMultiplier, 2);

        return [
            'min' => round($suggested * 0.9, 2),
            'recommended' => $suggested,
            'max' => round($suggested * 1.15, 2),
            'multiplier_breakdown' => [
                'district' => $districtMultiplier,
                'vertical' => $verticalMultiplier,
                'demand' => $demandMultiplier,
                'seasonality' => $seasonalityMultiplier,
                'weather' => $weatherMultiplier,
                'local_events' => $eventMultiplier,
                'provider_score' => $providerMultiplier,
                'composite' => round($compositeMultiplier, 4),
            ],
        ];
    }

    private function toRangeMultiplier(float $value, float $min, float $max): float
    {
        $normalized = max(0.0, min(1.0, $value));

        return round($min + (($max - $min) * $normalized), 4);
    }

    private function seasonalityMultiplier(string $seasonality): float
    {
        return match (strtolower($seasonality)) {
            'peak' => 1.14,
            'off_peak' => 0.92,
            default => 1.00,
        };
    }

    private function weatherMultiplier(string $weather): float
    {
        return match (strtolower($weather)) {
            'rain', 'storm' => 0.95,
            'festival_clear', 'sunny' => 1.04,
            default => 1.00,
        };
    }

    private function eventMultiplier(int $localEventCount): float
    {
        $count = max(0, min(5, $localEventCount));

        return round(1 + ($count * 0.015), 4);
    }

    private function providerMultiplier(float $providerScore): float
    {
        $normalized = max(0.0, min(100.0, $providerScore)) / 100.0;

        return $this->toRangeMultiplier($normalized, 0.96, 1.06);
    }
}
