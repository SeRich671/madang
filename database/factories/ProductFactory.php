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
        $isAvailable = $this->faker->boolean;

        return [
            'code' => $this->faker->word,
            'name' => $this->faker->name,
            'description' => $this->faker->sentence(10),
            'price' => $this->faker->randomFloat(2, 20,30),
            'discount_price' => $this->faker->optional()->randomFloat(2, 10,19),
            'is_available' => $isAvailable,
            'is_recommended' => $this->faker->boolean,
            'sticker' => $this->faker->boolean,
            'later_delivery' => $this->faker->boolean,
            'material' => $this->faker->sentence(2),
            'img_path' => 'products/default.jpg',
            'size_set' => '30x60',
            'size_carton' => '40x70',
            'size' => '20x10',
            'last_available' => !$isAvailable ? now()->subDay() : null
        ];
    }
}
