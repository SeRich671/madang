<?php

namespace Database\Factories;

use App\Enums\User\RoleEnum;
use App\Enums\User\StatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'login' => fake()->unique()->userName,
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'company_name' => fake()->company,
            'company_address' => fake()->address,
            'company_city' => fake()->city,
            'company_zipcode' => fake()->postcode,
            'company_fax' => fake()->phoneNumber,
            'phone' => fake()->phoneNumber,
            'email' => fake()->unique()->safeEmail(),
            'nip' => fake()->numberBetween(1000000, 9999999),
            'marketing' => fake()->boolean,
            'status' => fake()->randomElement(StatusEnum::getValues()),
            'role' => RoleEnum::USER,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
