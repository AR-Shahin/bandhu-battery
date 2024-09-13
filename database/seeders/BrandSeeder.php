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
                'name_en' => 'Hamco',
                'name_bn' => 'হ্যামকো',
            ],
            [
                'name_en' => 'Rahim Afro',
                'name_bn' => 'রহিম আফ্রো',
            ],
        ]);
    }
}
