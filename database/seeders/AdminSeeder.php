<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name' => 'Admin Coinbase',
            'email' => 'admin2025@coinbase.com',
            'password' => Hash::make('Coinbase123'),
        ]);

        Admin::create([
            'name' => 'Admin Binance',
            'email' => 'admin2025@binance.com',
            'password' => Hash::make('Binance123'),
        ]);

    }



}


