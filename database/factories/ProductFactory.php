<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'thumbnail' => $this->faker->imageUrl($width = 1000, $height = 600),
            'sku' => $this->faker->unique()->word(),
            'tagline' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'stock' => rand(5, 10),
            'price' => rand(50, 1000),
            'store_id' => 1,
            'user_id' => 1,
        ];
    }
}
