<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stores>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company,
            'email' => $this->faker->unique()->safeEmail,
            'address1' => $this->faker->streetAddress,
            'address2' => $this->faker->secondaryAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'postal_code' => $this->faker->postcode,
            'country' => $this->faker->country,
            'logo' => $this->faker->imageUrl($width = 640, $height = 480),
            'cover' => $this->faker->imageUrl($width = 1000, $height = 600),
            // 'user_id' => 1,
            // 'user_id' => User::factory()
        ];
    }
}
