<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Cache;

class BusinessControlService
{
    private const CACHE_KEY = 'business_controls.overrides';

    public function getControls(): array
    {
        $defaults = config('business_controls', []);
        $overrides = Cache::get(self::CACHE_KEY, []);

        return array_replace_recursive($defaults, $overrides);
    }

    public function updateControls(array $input): array
    {
        $currentOverrides = Cache::get(self::CACHE_KEY, []);
        $nextOverrides = array_replace_recursive($currentOverrides, $this->sanitize($input));

        Cache::forever(self::CACHE_KEY, $nextOverrides);

        return $this->getControls();
    }

    public function clearOverrides(): array
    {
        Cache::forget(self::CACHE_KEY);

        return $this->getControls();
    }

    public function commissionRateForVertical(string $vertical, float $fallback): float
    {
        $controls = $this->getControls();
        $minRate = (float) ($controls['min_commission_rate'] ?? 0.04);
        $maxRate = (float) ($controls['max_commission_rate'] ?? 0.25);
        $overrides = $controls['commission_overrides'] ?? [];

        $candidate = $overrides[$vertical] ?? null;
        if ($candidate === null) {
            return $fallback;
        }

        return max($minRate, min($maxRate, (float) $candidate));
    }

    public function referralBonusPoints(string $audience): int
    {
        $controls = $this->getControls();
        $multiplier = max(0.1, (float) ($controls['referral_multiplier'] ?? 1.0));
        $base = $audience === 'referred'
            ? (int) ($controls['referral_bonus_points_referred'] ?? 250)
            : (int) ($controls['referral_bonus_points_referrer'] ?? 500);

        $minimum = (int) ($controls['minimum_referral_points'] ?? 50);
        $maximum = (int) ($controls['maximum_referral_points'] ?? 10000);

        $effective = (int) round($base * $multiplier);

        return max($minimum, min($maximum, $effective));
    }

    private function sanitize(array $input): array
    {
        $sanitized = [];

        if (array_key_exists('commission_overrides', $input) && is_array($input['commission_overrides'])) {
            $sanitized['commission_overrides'] = [];
            foreach ($input['commission_overrides'] as $vertical => $rate) {
                $sanitized['commission_overrides'][(string) $vertical] = $rate === null ? null : (float) $rate;
            }
        }

        if (array_key_exists('referral_bonus_points_referrer', $input)) {
            $sanitized['referral_bonus_points_referrer'] = (int) $input['referral_bonus_points_referrer'];
        }
        if (array_key_exists('referral_bonus_points_referred', $input)) {
            $sanitized['referral_bonus_points_referred'] = (int) $input['referral_bonus_points_referred'];
        }
        if (array_key_exists('referral_multiplier', $input)) {
            $sanitized['referral_multiplier'] = (float) $input['referral_multiplier'];
        }

        return $sanitized;
    }
}
