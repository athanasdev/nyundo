<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReferralSetting extends Model
{
    use HasFactory;

    protected $table = 'referral_settings';

    // No need to set $keyType unless you're using string keys
    // public $incrementing = true; // This is already true by default for integer PKs

    protected $fillable = [
        'level',
        'commission_percentage',
    ];

    protected $casts = [
        'level' => 'integer',
        'commission_percentage' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


}
