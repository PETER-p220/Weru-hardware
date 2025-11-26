<?php

return [
    'base_url' => env('SELCOM_BASE_URL'),
    'live' => env('SELCOM_IS_LIVE', false),
    'vendor_id' => env('SELCOM_VENDOR_ID'),
    'api_key' => env('SELCOM_API_KEY'),
    'api_secret' => env('SELCOM_API_SECRET'),
    'return_url' => env('SELCOM_RETURN_URL'),
    'cancel_url' => env('SELCOM_CANCEL_URL'),
];