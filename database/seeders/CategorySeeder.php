<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            "Battery", "Water","Solar"
        ];

        foreach($categories as $categories){
            Category::create([
                "bn_name" => $categories,
                "en_name" => $categories
            ]);
        }
    }
}
