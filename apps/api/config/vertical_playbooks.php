<?php

return [
    'colombo' => [
        'stays' => [
            'supply_mix' => 'premium_business_leisure',
            'pricing_band' => ['min' => 55, 'recommended' => 95, 'max' => 180],
            'sla' => ['response_minutes' => 10, 'fulfillment_hours' => 2],
            'notes' => 'Prioritize weekend demand spikes and event-driven surge windows.',
        ],
        'tours' => [
            'supply_mix' => 'urban_culture_food',
            'pricing_band' => ['min' => 18, 'recommended' => 42, 'max' => 90],
            'sla' => ['response_minutes' => 20, 'fulfillment_hours' => 6],
            'notes' => 'Bundle food + culture experiences for higher attachment rates.',
        ],
        'vehicles' => [
            'supply_mix' => 'airport_transfer_city_commute',
            'pricing_band' => ['min' => 25, 'recommended' => 48, 'max' => 105],
            'sla' => ['response_minutes' => 8, 'fulfillment_hours' => 1],
            'notes' => 'Use check-in and OTP proof for premium transfer releases.',
        ],
    ],
    'kandy' => [
        'stays' => [
            'supply_mix' => 'heritage_nature',
            'pricing_band' => ['min' => 40, 'recommended' => 72, 'max' => 140],
            'sla' => ['response_minutes' => 15, 'fulfillment_hours' => 4],
            'notes' => 'Increase seasonal weight during festival and school holiday windows.',
        ],
        'tours' => [
            'supply_mix' => 'scenic_spiritual',
            'pricing_band' => ['min' => 15, 'recommended' => 35, 'max' => 78],
            'sla' => ['response_minutes' => 25, 'fulfillment_hours' => 8],
            'notes' => 'Cross-sell evening experiences to stay bundles.',
        ],
    ],
    'galle' => [
        'stays' => [
            'supply_mix' => 'coastal_boutique',
            'pricing_band' => ['min' => 48, 'recommended' => 88, 'max' => 165],
            'sla' => ['response_minutes' => 12, 'fulfillment_hours' => 3],
            'notes' => 'Weather-sensitive demand; use weather multipliers actively.',
        ],
        'home_beauty' => [
            'supply_mix' => 'spa_wellness_mobile',
            'pricing_band' => ['min' => 12, 'recommended' => 28, 'max' => 64],
            'sla' => ['response_minutes' => 20, 'fulfillment_hours' => 6],
            'notes' => 'Bundle wellness with coastal stay packages for conversion lifts.',
        ],
    ],
];
