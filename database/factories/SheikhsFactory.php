<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sheikhs>
 */
class SheikhsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' =>fake()->name(),
            'email' =>fake()->unique()->safeEmail(),
            'phone' =>fake()->phoneNumber(),
            'age' =>rand(30,40),
            'image' => fake()->imageUrl(),
            'gender' => 'male',
            'level_of_english'=> implode(', ', fake()->words(1)),
            'vacation'=> rand(1,2),
            'education' => 'university azhar',
            'time_available'=> fake()->time(),
            'studies'=>rand(1,4),
            'links'=>fake()->url(),
            'cv'=>implode(', ', fake()->words(2)),
            'recommendations'=> 'facebook',
            'title'=>fake()->jobTitle(),
            'description'=>fake()->paragraph(2),
            'experience'=>implode(', ', fake()->words(5)),
        ];
    }
}
