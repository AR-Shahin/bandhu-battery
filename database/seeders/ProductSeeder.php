<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'হামকো ব্যাটারি', 'description' => 'হামকো ব্যাটারি পণ্যের বিবরণ'],
            ['name' => 'সোলার প্যানেল', 'description' => 'সোলার প্যানেল পণ্যের বিবরণ'],
            ['name' => 'ল্যাপটপ', 'description' => 'ল্যাপটপ পণ্যের বিবরণ'],
            ['name' => 'মোবাইল ফোন', 'description' => 'মোবাইল ফোন পণ্যের বিবরণ'],
            ['name' => 'ক্যামেরা', 'description' => 'ক্যামেরা পণ্যের বিবরণ'],
            ['name' => 'ইনভার্টার', 'description' => 'ইনভার্টার পণ্যের বিবরণ'],
            ['name' => 'টিভি', 'description' => 'টিভি পণ্যের বিবরণ'],
            ['name' => 'ফ্রিজ', 'description' => 'ফ্রিজ পণ্যের বিবরণ'],
            ['name' => 'মাইক্রোওভেন', 'description' => 'মাইক্রোওভেন পণ্যের বিবরণ'],
            ['name' => 'ওয়াশিং মেশিন', 'description' => 'ওয়াশিং মেশিন পণ্যের বিবরণ']
        ];

        foreach ($products as $product) {
            $product = Product::create([
                'category_id' => 1,
                'brand_id' => 1,
                'unit_id' => 1,
                'vendor_id' => 1,
                'name' => $product['name'],
                'code' => "-",
                'status' => 1,
                'stock' => rand(10, 100),
                'description' => $product['description'],
                'admin_id' => 1,
            ]);
            $product->update([
                "code" => "PN-{$product->id}"
            ]);
            $product->update_stock(
                $product->stock ?? 0,
                ProductStock::ADD,
                "When Product added!"
            );
        }
    }
}
