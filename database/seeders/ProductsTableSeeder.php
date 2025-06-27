<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Laptop',
                'description' => 'Powerful laptop with 16GB RAM and 512GB SSD',
                'price' => 999.99,
                'stock' => 50,
                'image' => 'products/laptop.jpeg',
            ],
            [
                'name' => 'Smartphone',
                'description' => 'Latest smartphone with 6.5" display and triple camera',
                'price' => 699.99,
                'stock' => 100,
                'image' => 'products/phone.jpeg',
            ],
            [
                'name' => 'Headphones',
                'description' => 'Wireless noise-cancelling headphones',
                'price' => 249.99,
                'stock' => 200,
                'image' => 'products/headphone.jpeg',
            ],
            [
                'name' => 'Smart Watch',
                'description' => 'Fitness tracker with heart rate monitor',
                'price' => 199.99,
                'stock' => 75,
                'image' => 'products/watch.jpeg',
            ],
            [
                'name' => 'Tablet',
                'description' => '10" tablet with stylus support',
                'price' => 349.99,
                'stock' => 60,
                'image' => 'products/tablet.jpeg',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
