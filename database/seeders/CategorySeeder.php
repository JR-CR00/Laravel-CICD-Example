<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Home Appliances',
                'description' => 'Electrical machines which help in household functions.',
            ],
            [
                'name' => 'Clothing',
                'description' => 'Apparel and fashion items for all ages.',
            ],
            [
                'name' => 'Electronics',
                'description' => 'Gadgets, computers, and electronic devices.',
            ],
            [
                'name' => 'Home & Garden',
                'description' => 'Furniture, decor, and gardening tools.',
            ],
            [
                'name' => 'Sports & Outdoors',
                'description' => 'Equipment for sports and outdoor activities.',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => true,
            ]);
        }
    }
}
