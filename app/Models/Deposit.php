<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'network',
        'deposit_address',
        'amount',
        'status',
        'currency',
        'type',
    ];

    // You might also want casts for amount
    protected $casts = [
        'amount' => 'decimal:6', // Matches your DB schema decimal(20,6)
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

