<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Laptop',
            'price' => 8000000,
            'stock' => 10,
        ]);

        Product::create([
            'name' => 'Mouse',
            'price' => 150000,
            'stock' => 20,
        ]);

        Product::create([
            'name' => 'Keyboard',
            'price' => 300000,
            'stock' => 15,
        ]);
    }
}