<?php

namespace Database\Factories;

use App\Enums\Department\StatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image' => 'departments/default.png',
            'status' => StatusEnum::ON,
            'footer_type' => 'DEFAULT',
        ];
    }
}
