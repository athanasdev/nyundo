<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInvestment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_setting_id',
        'investment_date',
        'amount',
        'daily_profit_amount',
        'investment_result',   // enum lose/gain
        'type',                // enum buy/sell
        'crypto_category',     // enum for crypto categories
        'total_profit_paid_out',
        'principal_returned',
        'game_start_time',    // rename to actual DB column
        'game_end_time',      // rename to actual DB column
    ];

    protected $casts = [
        'investment_date' => 'date',
        'game_start_time' => 'datetime',   // actual DB column
        'game_end_time' => 'datetime',     // actual DB column
        'amount' => 'decimal:6',
        'daily_profit_amount' => 'decimal:6',
        'total_profit_paid_out' => 'decimal:6',
        'principal_returned' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
