<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['min_withdraw_amount', 'withdraw_fee_percentage'];
}



