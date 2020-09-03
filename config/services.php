<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'onesignal' => [
        'app_id' => env('ONESIGNAL_APP_ID'),
        'rest_api_key' => env('ONESIGNAL_REST_API_KEY'),
        'user_auth_key' => env('user_auth_key')
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'twilio' => [
     'sid' => env('TWILIO_ACCOUNT_SID'),
     'token' => env('TWILIO_ACCOUNT_TOKEN'),
     'key' => env('TWILIO_API_KEY'),
     'secret' => env('TWILIO_API_SECRET')
    ],

    'google' => [
        'client_id' => '233612827309',
        'client_secret' => 'r9jZZ3gBp0Ag3w-D5r5fm_CI',
        'redirect' => 'https://dev.msnsoft.org/callback/google',
    ],
    'facebook' => [
        'client_id' => '640691546715734',
        'client_secret' => '34df3fa2fbbd9f96d492e5341132bb12',
        'redirect' => 'https://dev.msnsoft.org/callback/facebook',
    ],
    'sendsms' => [
        'user' => env('DAY_WISE_SMS_USER'),
        'pass' => env('DAY_WISE_SMS_PASS'),
        'from' => env('DAY_WISE_SMS_SENDER_ID')
    ],

];
