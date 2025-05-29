<?php
return [
    'merchant_id' => env('COINPAYMENTS_MERCHANT_ID'),
    'public_key'  => env('COINPAYMENTS_PUBLIC_KEY'),
    'private_key' => env('COINPAYMENTS_PRIVATE_KEY'),
    'ipn_secret'  => env('COINPAYMENTS_IPN_SECRET'),
    'ipn_url'     => env('COINPAYMENTS_IPN_URL'),
    'success_url' => env('COINPAYMENTS_SUCCESS_URL'),
    'cancel_url'  => env('COINPAYMENTS_CANCEL_URL'),
    // You might not need format and api_url here if the SDK handles them
];
