<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'payment_id',
        'purchase_id',
        'order_id',
        'payment_status',
        'price_amount',
        'price_currency',
        'pay_amount',
        'pay_currency',
        'amount_received',
        'pay_address',
        'network',
        'payment_created_at',
        'payment_updated_at',
    ];

    protected $casts = [
        'payment_created_at' => 'datetime',
        'payment_updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}

