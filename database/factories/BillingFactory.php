<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Billing>
 */
class BillingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'company_name' => fake()->company,
            'city' => fake()->city,
            'address' => fake()->address,
            'zipcode' => fake()->postcode,
            'phone' => fake()->phoneNumber,
            'email' => fake()->email,
            'nip' => fake()->numerify('###-###-###-###'),
        ];
    }
}
