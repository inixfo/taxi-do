<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Stripe API Keys
    |--------------------------------------------------------------------------
    */
    'api_key' => env('STRIPE_API_KEY'),
    'secret_key' => env('STRIPE_SECRET_KEY'),
    'webhook_secret' => env('STRIPE_WEBHOOK_SECRET_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Stripe Payment Methods Configuration
    |--------------------------------------------------------------------------
    |
    | Configure which payment methods are enabled for Stripe payments.
    | Apple Pay and Google Pay require additional merchant configuration.
    |
    */
    'payment_methods' => [
        'card' => env('STRIPE_CARD_ENABLED', true),
        'apple_pay' => env('STRIPE_APPLE_PAY_ENABLED', true),
        'google_pay' => env('STRIPE_GOOGLE_PAY_ENABLED', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Apple Pay Configuration
    |--------------------------------------------------------------------------
    |
    | Apple Pay requires domain verification and a merchant ID.
    | Register your domain at: https://dashboard.stripe.com/settings/payments/apple_pay
    |
    */
    'apple_pay' => [
        'merchant_id' => env('STRIPE_APPLE_PAY_MERCHANT_ID', 'merchant.uk.co.wayder'),
        'merchant_name' => env('STRIPE_APPLE_PAY_MERCHANT_NAME', 'Wayder'),
        'supported_networks' => ['visa', 'mastercard', 'amex'],
        'merchant_capabilities' => ['3DS'],
        'country_code' => env('STRIPE_APPLE_PAY_COUNTRY', 'GB'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Google Pay Configuration
    |--------------------------------------------------------------------------
    |
    | Google Pay configuration for the Android app.
    | Register at: https://pay.google.com/business/console
    |
    */
    'google_pay' => [
        'merchant_id' => env('STRIPE_GOOGLE_PAY_MERCHANT_ID'),
        'merchant_name' => env('STRIPE_GOOGLE_PAY_MERCHANT_NAME', 'Wayder'),
        'environment' => env('STRIPE_GOOGLE_PAY_ENVIRONMENT', 'TEST'), // 'TEST' or 'PRODUCTION'
        'country_code' => env('STRIPE_GOOGLE_PAY_COUNTRY', 'GB'),
        'currency_code' => env('STRIPE_GOOGLE_PAY_CURRENCY', 'GBP'),
        'allowed_card_networks' => ['VISA', 'MASTERCARD', 'AMEX'],
        'allowed_auth_methods' => ['PAN_ONLY', 'CRYPTOGRAM_3DS'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Stripe Connect Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Stripe Connect (driver payouts).
    |
    */
    'connect' => [
        'enabled' => env('STRIPE_CONNECT_ENABLED', true),
        'account_type' => 'express', // 'express', 'standard', or 'custom'
        'country' => 'GB',
        'payout_schedule' => [
            'interval' => 'weekly',
            'weekly_anchor' => 'monday',
        ],
        'default_currency' => 'gbp',
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Intent Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for payment intents with manual capture.
    |
    */
    'payment_intent' => [
        'capture_method' => 'manual', // 'automatic' or 'manual'
        'confirmation_method' => 'automatic',
        'setup_future_usage' => 'off_session',
        'currency' => 'gbp',
        // Authorization expires after 7 days
        'authorization_validity_days' => 7,
    ],
];
