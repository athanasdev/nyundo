<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferralSettingsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('referral_settings')->insert([
            ['level' => 1, 'commission_percentage' => 8.00, 'created_at' => now(), 'updated_at' => now()],
            ['level' => 2, 'commission_percentage' => 4.00, 'created_at' => now(), 'updated_at' => now()],
            ['level' => 3, 'commission_percentage' => 2.00, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
