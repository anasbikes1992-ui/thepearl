<?php

return [
    'rate_limits' => [
        'public' => 120,
        'authenticated' => 300,
        'concierge' => 60,
    ],
    'idor_enforcement' => true,
    'audit_trail_enabled' => true,
    'allowed_locales' => ['en', 'si', 'ta'],
];
