<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            DB::table('products')->insert([
                'name' => Str::random(10),
                'description' => Str::random(10),
                'price' => rand(100, 300),
                'stock_quantity' => rand(10, 100),
            ]);
        }
        
    }
}
