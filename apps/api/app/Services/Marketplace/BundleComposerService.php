<?php

namespace App\Services\Marketplace;

use App\Enums\Listing\Vertical;
use App\Models\Listing\Listing;

class BundleComposerService
{
    public function compose(array $context): array
    {
        $city = $context['city'] ?? null;
        $district = $context['district'] ?? null;
        $budget = (float) ($context['budget'] ?? 0);
        $verticalTargets = $context['vertical_targets'] ?? [
            Vertical::Stays->value,
            Vertical::Tours->value,
            Vertical::Vehicles->value,
            Vertical::HomeBeauty->value,
        ];

        $selected = [];
        $runningTotal = 0.0;

        foreach ($verticalTargets as $vertical) {
            $query = Listing::query()->where('vertical', $vertical);

            if (!empty($city)) {
                $query->where('city', $city);
            }
            if (!empty($district)) {
                $query->where('district', $district);
            }

            $listing = $query->orderBy('base_price')->first();
            if (!$listing) {
                continue;
            }

            $nextTotal = $runningTotal + (float) $listing->base_price;
            if ($budget > 0 && $nextTotal > $budget) {
                continue;
            }

            $selected[] = [
                'listing_id' => $listing->id,
                'vertical' => $listing->vertical->value,
                'title' => $listing->title,
                'city' => $listing->city,
                'district' => $listing->district,
                'price' => (float) $listing->base_price,
                'currency' => $listing->currency,
            ];
            $runningTotal = $nextTotal;
        }

        $bundleDiscountRate = count($selected) >= 3 ? 0.07 : 0.0;
        $discountAmount = round($runningTotal * $bundleDiscountRate, 2);

        return [
            'items' => $selected,
            'subtotal' => round($runningTotal, 2),
            'discount_rate' => $bundleDiscountRate,
            'discount_amount' => $discountAmount,
            'total' => round($runningTotal - $discountAmount, 2),
            'conversion_cta' => count($selected) > 0
                ? 'Reserve this cross-vertical bundle now to lock price and availability.'
                : 'No bundle available for selected constraints. Try a larger budget or nearby district.',
        ];
    }
}
