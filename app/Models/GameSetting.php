<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // Make sure to import Carbon

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
        'start_time' => 'datetime', // Add casting for start_time
        'end_time' => 'datetime',   // Add casting for end_time
        'is_active' => 'boolean',
        'payout_enabled' => 'boolean',
        'earning_percentage' => 'decimal:2', // Ensures 2 decimal places for percentage
        'created_at' => 'datetime', // Good practice to cast these too
        'updated_at' => 'datetime', // Good practice to cast these too
    ];

    /**
     * Define the timezone to use for admin input/display.
     * In a real application, this might be dynamic based on the logged-in admin's profile.
     * For this example, we'll hardcode it to a specific timezone.
     *
     * @return string
     */
    public static function getAdminTimezone(): string
    {
        // Using 'Africa/Nairobi' as an example (EAT, UTC+3).
        // Adjust this to the timezone most relevant for your administrators.
        return 'Africa/Nairobi';
    }

    public function investments()
    {
        return $this->hasMany(UserInvestment::class, 'game_setting_id');
    }
    
}
