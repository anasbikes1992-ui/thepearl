<?php

return [
    'openai' => [
        'key' => env('OPENAI_API_KEY'),
    ],

    'grok' => [
        'key' => env('GROK_API_KEY'),
    ],

    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'payhere' => [
        'merchant_id' => env('PAYHERE_MERCHANT_ID'),
        'merchant_secret' => env('PAYHERE_MERCHANT_SECRET'),
    ],
];
