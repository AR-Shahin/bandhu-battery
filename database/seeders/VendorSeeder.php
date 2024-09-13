<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vendors')->insert([
            [
                'name' => 'মোঃ আবদুল্লাহ',
                'email' => 'abdullah@example.com',
                'phone' => '01711111111',
                'phone_2' => '01811111111',
                'address' => 'ঢাকা, বাংলাদেশ',
            ],
            [
                'name' => 'মোঃ কামরুল হাসান',
                'email' => 'kamrul@example.com',
                'phone' => '01722222222',
                'phone_2' => null,
                'address' => 'চট্টগ্রাম, বাংলাদেশ',
            ],
            [
                'name' => 'সুমাইয়া আক্তার',
                'email' => 'sumaiya@example.com',
                'phone' => '01733333333',
                'phone_2' => '01833333333',
                'address' => 'খুলনা, বাংলাদেশ',
            ],
        ]);

    }
}
