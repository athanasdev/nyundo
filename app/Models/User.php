<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'currency',
        'unique_id',
        'referral_code',
        'referrer_id',
        'balance', // Added: Important for updating user balances
        'status',  // Added: If you update user status via mass assignment
        'withdraw_amount', // Added: If you update this via mass assignment
        'country',
        // New fields:
        'withdrawal_address',
        'withdrawal_pin_hash', // Though you might not mass-assign the hash directly
        'withdrawal_pin_set_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'withdrawal_pin_hash',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'balance'           => 'decimal:2',       // Added: Ensures correct decimal handling for balance
            'withdraw_amount'   => 'decimal:2',       // Added: Ensures correct decimal handling for withdraw_amount
            'withdrawal_pin_set_at' => 'datetime',
        ];
    }


    /**
     * Set the user's withdrawal PIN (hashed).
     *
     * @param  string  $rawPin
     * @return void
     */
    public function setWithdrawalPin(string $rawPin): void
    {
        $this->attributes['withdrawal_pin_hash'] = Hash::make($rawPin);
        $this->attributes['withdrawal_pin_set_at'] = Carbon::now();
        // No need to call $this->save() here if you call it in the controller after this method.
        // Or, you can call $this->save() if this method is the sole point of update for these.
    }

    /**
     * Check if the given raw PIN matches the user's hashed withdrawal PIN.
     *
     * @param  string  $rawPin
     * @return bool
     */
    public function checkWithdrawalPin(string $rawPin): bool
    {
        if (empty($this->attributes['withdrawal_pin_hash'])) {
            return false; // No PIN set
        }
        return Hash::check($rawPin, $this->attributes['withdrawal_pin_hash']);
    }

    // Model relationships

    public function investments()
    {
        return $this->hasMany(UserInvestment::class);
    }


    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the user who referred this user (the parent referrer).
     * This defines the inverse relationship for the 'referrer_id' column.
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    /**
     * Get the users that were directly referred by this user.
     * This defines the one-to-many relationship for direct referrals.
     */
    public function referrals()
    {
        return $this->hasMany(User::class, 'referrer_id');
    }
}
