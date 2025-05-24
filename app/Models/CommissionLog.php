<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionLog extends Model
{
    protected $fillable = [
        'user_id',
        'who',
        'level',
        'amount',
        'main_amo',
        'title',
        'trx',
    ];


}

