<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->word();
        return [
            'parent_category_id' => null,
            'name' => ucfirst($name),
            'slug' => \Illuminate\Support\Str::slug($name),
            'description' => $this->faker->sentence(),
            'is_active' => true,
        ];
    }
}
