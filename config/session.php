<?php
// config/session.php

return [
    'driver' => env('SESSION_DRIVER', 'file'),
    'lifetime' => env('SESSION_LIFETIME', 1440),
    'expire_on_close' => false,
    'encrypt' => env('SESSION_ENCRYPT', true),
    'files' => storage_path('framework/sessions'),
    'connection' => env('SESSION_CONNECTION'),
    'table' => 'sessions',
    'store' => env('SESSION_STORE'),
    'lottery' => [2, 100],
    'cookie' => env('SESSION_COOKIE', 'tokodeden_session'),
    'path' => env('SESSION_PATH', '/'),
    'domain' => env('SESSION_DOMAIN'),
    'secure' => env('SESSION_SECURE', true),
    'http_only' => true,
    'same_site' => env('SESSION_SAME_SITE', 'lax'),
];
