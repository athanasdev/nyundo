<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainAccount extends Model
{
    protected $fillable = [
        'deposit_address',
        'password',
        'currency',
        'admin_id',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }


}
