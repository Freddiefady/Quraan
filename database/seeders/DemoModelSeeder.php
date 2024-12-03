<?php

namespace Database\Seeders;

use App\Models\DemoModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DemoModel::factory()->count(20)->create();
    }
}
