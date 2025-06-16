<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromoSeeder extends Seeder
{
    public function run()
    {
        DB::table('promos')->insert([
            'title' => 'PROMO JUNI 2025',
            'period' => '01 Juni - 30 Juni 2025',
            'description' => 'Dapatkan promo menarik bulan Juni! Yuk langsung ke Speed Solution terdekat ✨',
            'terms' => 'S&K: Pembelian langsung ke outlet, berlaku selama persediaan masih ada',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}