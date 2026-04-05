<?php

return [
    'name' => env('APP_NAME', 'PearlHubAPI'),
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => 'Asia/Colombo',
    'locale' => env('APP_LOCALE', 'en'),
    'fallback_locale' => 'en',
    'faker_locale' => 'en_US',
    'cipher' => 'AES-256-CBC',
    'key' => env('APP_KEY'),
    'providers' => [
        App\Providers\AppServiceProvider::class,
    ],
];