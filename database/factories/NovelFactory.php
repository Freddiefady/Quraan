<?php

namespace Database\Factories;

use App\Models\Reads;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Novel>
 */
class NovelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = fake()->date('Y-m-d H:m:s');
        return [
            'name'=>fake()->sentence(3),
            'description'=>fake()->paragraph(5),
            'read_id'=>Reads::inRandomOrder()->first()->id,
            'created_at'=> $date,
            'updated_at'=> $date
        ];
    }
}
