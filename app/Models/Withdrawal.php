<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setWithdrawPasswordAttribute($value)
    {
        $this->attributes['withdraw_password'] = bcrypt($value);
    }

    
}
