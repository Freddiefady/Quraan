<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Sheikhs;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'=>fake()->jobTitle(),
            'description'=>fake()->sentence(3),
            'price'=>fake()->randomFloat(2, 1, 500),
            'sheikh_id'=>Sheikhs::inRandomOrder()->first()->id,
            'admin_id'=>Admin::inRandomOrder()->first()->id,
        ];
    }
}
