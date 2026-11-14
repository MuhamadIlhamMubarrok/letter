<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Digital Story Storage Configuration
    |--------------------------------------------------------------------------
    */
    'disk' => env('DIGITAL_STORY_DISK', 'public'),
    'paths' => [
        'qr_codes' => 'stories/qr',
        'photos' => 'stories/photos',
        'audio' => 'stories/audio',
    ],

    /*
    |--------------------------------------------------------------------------
    | Upload Limits (Kilobytes & Counts)
    |--------------------------------------------------------------------------
    */
    'limits' => [
        'max_photo_size_kb' => (int) env('DIGITAL_STORY_MAX_PHOTO_KB', 5120), // 5MB
        'max_photo_count' => (int) env('DIGITAL_STORY_MAX_PHOTOS', 5),
        'max_audio_size_kb' => (int) env('DIGITAL_STORY_MAX_AUDIO_KB', 10240), // 10MB
        'max_guest_count_per_rsvp' => (int) env('DIGITAL_STORY_MAX_GUEST_COUNT', 10),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Pricing & Plans (in IDR)
    |--------------------------------------------------------------------------
    */
    'pricing' => [
        '1_month' => 35000,
        '6_months' => 75000,
        '1_year' => 120000,
        'lifetime' => 200000,
    ],
];
