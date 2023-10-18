<?php

return [
    'payment' => [
        'merchant_account_number' => env('HUBTEL_MERCHANT_ACCOUNT_NUMBER'),
        'client_id' => env('HUBTEL_CLIENT_ID'),
        'client_secret' => env('HUBTEL_CLIENT_SECRET'),
        'online_checkout_url' => env('HUBTEL_ONLINE_CHECKOUT_URL'),
    ],
];
