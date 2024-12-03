<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Articles>
 */
class ArticlesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $data = fake()->date('Y-m-d h:m:s');
        return [
            'title'=>fake()->sentence(3),
            'content'=>fake()->paragraph(5),
            'status'=> rand(0,1),
            'satisfied'=> rand(1,2),
            'admin_id'=> Admin::inRandomOrder()->first()->id,
            'user_id'=> User::inRandomOrder()->first()->id,
            'rating_id'=> Rating::inRandomOrder()->first()->id,
            'created_at'=> $data,
            'updated_at'=> $data,
        ];
    }
}
