<?php

// Branding and contact details shown on screens and printouts.
// Each clinic sets these in .env, so nothing clinic-specific is hard-coded in views.
return [
    // Name of the software product.
    'product_name' => env('CLINIC_PRODUCT_NAME', 'ClearSight EMR'),

    // Name of the clinic using the software (letterheads, page headers).
    'name' => env('CLINIC_NAME', 'ClearSight Eye Clinic'),
    'short_name' => env('CLINIC_SHORT_NAME', 'ClearSight'),
    'tagline' => env('CLINIC_TAGLINE', 'Comprehensive eye care'),

    'address' => env('CLINIC_ADDRESS', '12 Example Street, City'),
    'phone' => env('CLINIC_PHONE', '+234 800 000 0000'),
    'email' => env('CLINIC_EMAIL', 'info@clinic.local'),

    // Sender ID used for SMS when the SMS account does not set one (max 11 characters).
    'sms_sender' => env('CLINIC_SMS_SENDER', 'ClearSight'),

    // Shown in the top bar so a demo or training copy can never be mistaken for the live system.
    // Leave CLINIC_ENVIRONMENT_LABEL empty to derive it from APP_ENV ("production" counts as live).
    'environment' => [
        'is_live' => env('APP_ENV', 'production') === 'production',
        'label' => env('CLINIC_ENVIRONMENT_LABEL') ?: (env('APP_ENV', 'production') === 'production'
            ? 'LIVE'
            : strtoupper((string) env('APP_ENV')).' - not live patient data'),
    ],

    // Modules that are not finished yet stay hidden unless switched on.
    'features' => [
        'telemedicine' => (bool) env('CLINIC_FEATURE_TELEMEDICINE', false),
    ],
];
