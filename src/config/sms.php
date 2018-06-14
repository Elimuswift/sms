<?php

/*
 * https://simplesoftware.io/docs/simple-sms#docs-configuration for more information.
 */
return [
    'driver' => env('SMS_DRIVER', 'africastalking'),

    'from' => env('SMS_FROM', 'Your Number or Email'),

    'africastalking' => [
        'api_key' => env('AT_API_KEY', 'africastalking.api_key'),
        'username' => env('AT_USERNAME', 'africastalking.username'),
        'sandbox' => true,
    ],

    'nexmo' => [
        'api_key' => env('NEXMO_KEY', 'Your Nexmo API key'),
        'api_secret' => env('NEXMO_SECRET', 'Your Nexmo API secret'),
        'encoding' => env('NEXMO_ENCODING', 'unicode'), // Can be "unicode" or "gsm"
    ],

    'twilio' => [
        'account_sid' => env('TWILIO_SID', 'Your Twilio SID'),
        'auth_token' => env('TWILIO_TOKEN', 'Your Twilio Token'),
        'verify' => env('TWILIO_VERIFY', true),
    ],

    'winsms' => [
        'api_key' => env('WINSMS_SECRET'),
    ],
];
