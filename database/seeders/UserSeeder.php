<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'Crypto User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user12345'),
        ]);
    }


}

