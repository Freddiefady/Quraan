<?php

namespace Database\Seeders;

use App\Models\Sheikhs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SheikhsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sheikhs::factory()->count(5)->create();
    }
}
