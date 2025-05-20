<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{


    protected $fillable = [
        'user_id',
        'level',
        'members',
        'deposit',
        'commissions',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

   
}
