<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | External APIs - Team 404
    |--------------------------------------------------------------------------
    */

    // Student System - Team CodeWave
    'student_api' => [
        'url' => env('STUDENT_API_URL', 'http://codewave-api.local'),
    ],

    // Token for incoming API requests (Transcript API)
    'api_access_token' => env('API_ACCESS_TOKEN', 'team404-secret-token'),

    // Staff System - Team DevX (Railway)
    'staff_api' => [
        'url' => env('STAFF_API_URL', 'https://academic-staff-management-system-production.up.railway.app'),
        'token' => env('STAFF_API_TOKEN', '4|Nv60FAImvmO3k81jxzHYgbCxTqc4j7DW4gkTAc4r58dfdade'),
    ],

];
