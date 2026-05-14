<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $electronics = Category::where('slug', 'electronics')->first();
        $clothing = Category::where('slug', 'clothing')->first();
        $homeAppliances = Category::where('slug', 'home-appliances')->first();

        $products = [
            [
                'category_id' => $electronics->id ?? 1,
                'name' => 'Smartphone Pro Max',
                'slug' => Str::slug('Smartphone Pro Max'),
                'sku' => 'PHONE-001',
                'barcode' => '1234567890123',
                'short_description' => 'Latest generation smartphone with top-tier camera.',
                'long_description' => 'This smartphone features a 6.7-inch display, triple-lens camera system, and all-day battery life.',
                'price' => 999.99,
                'discount_price' => 899.99,
                'stock' => 50,
                'status' => 'active',
                'is_featured' => true,
            ],
            [
                'category_id' => $clothing->id ?? 2,
                'name' => 'Classic Cotton T-Shirt',
                'slug' => Str::slug('Classic Cotton T-Shirt'),
                'sku' => 'SHIRT-001',
                'barcode' => '9876543210987',
                'short_description' => '100% organic cotton classic t-shirt.',
                'long_description' => 'A comfortable and durable classic t-shirt made from 100% organic cotton, perfect for everyday wear.',
                'price' => 25.00,
                'discount_price' => null,
                'stock' => 200,
                'status' => 'active',
                'is_featured' => false,
            ],
            [
                'category_id' => $homeAppliances->id ?? 3,
                'name' => 'Smart Coffee Maker',
                'slug' => Str::slug('Smart Coffee Maker'),
                'sku' => 'COFFEE-001',
                'barcode' => '5556667778889',
                'short_description' => 'Programmable coffee maker with Wi-Fi connectivity.',
                'long_description' => 'Brew your coffee from anywhere with your smartphone. Features include a 12-cup capacity and adjustable brew strength.',
                'price' => 120.50,
                'discount_price' => 99.00,
                'stock' => 30,
                'status' => 'active',
                'is_featured' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
