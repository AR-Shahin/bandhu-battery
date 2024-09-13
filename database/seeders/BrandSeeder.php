<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('brands')->insert([
            [
                'en_name' => 'Hamco',
                'bn_name' => 'হ্যামকো',
            ],
            [
                'en_name' => 'Rahim Afroz',
                'bn_name' => 'রহিম আফ্রো',
            ],
        ]);
    }
}
