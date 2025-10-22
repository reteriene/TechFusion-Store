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
            'sku' => strtoupper($this->faker->bothify('TF-#####')),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(12),
            'price' => $this->faker->randomFloat(2, 10, 1500),
            'stock' => $this->faker->numberBetween(0, 200),
            'is_featured' => $this->faker->boolean(20),
            'image_url' => $this->faker->imageUrl(640, 640, 'tech'),
        ];
    }
}