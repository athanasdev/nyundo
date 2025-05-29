<?php

namespace App\Services;

use CoinpaymentsAPI;

class CoinPaymentsService
{
    protected $cps;

    public function __construct()
    {
        $this->cps = new CoinpaymentsAPI(
            config('coinpayments.private_key'),
            config('coinpayments.public_key'),
            'json' // OR merchant_id if required by your version
        );
    }

    public function createTransaction(array $params)
    {
        return $this->cps->CreateCustomTransaction($params); // ✅ Valid method
    }

    
}
