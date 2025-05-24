<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Referral extends Model
{
    use HasFactory;
    protected $fillable = [
        'level', 'percent', 'status'
    ];
    protected $casts = [
        'percent' => 'decimal:2',
        'status' => 'boolean',
    ];


}


