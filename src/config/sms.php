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
    ],
];
