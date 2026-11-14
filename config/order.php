<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Order System Configuration
    |--------------------------------------------------------------------------
    | Menghilangkan magic numbers & strings hardcoded di dalam sistem order.
    */

    'code_charset' => env('ORDER_CODE_CHARSET', '23456789ABCDEFGHJKLMNPQRSTUVWXYZ'),
    'pickup_default_address' => 'Self Pick-up di Studio Maja Flower',
    'default_per_page' => 15,

    // Batas jam operasional dan threshold
    'operating_hours' => [
        'start' => '08:00',
        'end' => '20:00',
        'timezone' => 'Asia/Jakarta',
    ],
];
