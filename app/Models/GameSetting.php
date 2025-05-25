<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
        'earning_percentage',
        'is_active',
        'payout_enabled',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'payout_enabled' => 'boolean',
        'earning_percentage' => 'decimal:2', // Ensures 2 decimal places for percentage
    ];

    public function investments()
    {
        return $this->hasMany(UserInvestment::class, 'game_setting_id');
    }

    
}
