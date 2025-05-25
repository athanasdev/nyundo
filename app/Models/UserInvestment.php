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
        'status',
        'next_payout_eligible_date',
        'total_profit_paid_out',
        'principal_returned',
    ];

    protected $casts = [
        'investment_date' => 'date',
        'next_payout_eligible_date' => 'date', // Casts to Carbon instance
        'amount' => 'decimal:6',
        'daily_profit_amount' => 'decimal:6',
        'total_profit_paid_out' => 'decimal:6',
        'principal_returned' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gameSetting()
    {
        return $this->belongsTo(GameSetting::class, 'game_setting_id');
    }


}

