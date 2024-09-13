<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('units')->insert([
            [
                'en_name' => 'kg',
                'bn_name' => 'কেজি',
            ],
            [
                'en_name' => 'liter',
                'bn_name' => 'লিটার',
            ],
            [
                'en_name' => 'piece',
                'bn_name' => 'পিস',
            ],
        ]);
    }
}
