<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories.Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'sku' => 'TF-' . fake()->unique()->numerify('#####'),
            'name' => fake()->sentence(3),
            'description' => fake()->sentence(10),
            'price' => fake()->randomFloat(2, 10, 200),
            'stock' => fake()->numberBetween(0, 500),
            'is_featured' => fake()->boolean(),
            'image_url' => fake()->imageUrl(640, 640, 'tech'),
        ];
        
    }
}