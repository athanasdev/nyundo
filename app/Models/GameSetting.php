<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class GameSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
        'earning_percentage',
        'is_active',
        'payout_enabled',
        'type',
        'crypto_category',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_active' => 'boolean',
        'payout_enabled' => 'boolean',
        'earning_percentage' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Define the timezone to use for admin input/display, sourced from .env.
     *
     * @return string
     */
    public static function getAdminTimezone(): string
    {
        // Fetch the timezone from the environment variable (or a default if not set)
        return env('ADMIN_TIMEZONE', config('app.timezone', 'UTC'));
    }
}
