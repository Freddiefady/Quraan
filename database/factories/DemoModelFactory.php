<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nette\Utils\Random;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DemoModel>
 */
class DemoModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name'=>fake()->firstName(),
            'last_name'=>fake()->lastName(),
            'email'=>fake()->unique()->safeEmail(),
            'phone'=>fake()->phoneNumber(),
            'country'=>fake()->country(),
            'city'=>fake()->city(),
            'the_cycle'=>fake()->word(),
            'favorites_days'=>fake()->dayOfWeek(5),
            'favorites_time'=>fake()->time(),
            'age'=>rand(18,35),
            'student_gender'=>fake()->randomElement([0, 1]),
            'teacher_gender'=>fake()->randomElement([0, 1]),
            'message'=>fake()->sentence(6),
        ];
    }
}
