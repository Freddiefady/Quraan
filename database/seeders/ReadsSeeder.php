<?php

namespace Database\Seeders;

use App\Models\Reads;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReadsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = fake()->date('Y-m-d h:m:s');
        $data = [
            'Nafia reading',
            'Asem reading',
            'Hamza reading',
        ];
        foreach ($data as $item) {
            Reads::create([
                'name' => $item,
                'slug' => Str::slug($item),
                'created_at'=> $date,
                'updated_at'=> $date,
            ]);
        }
    }
}
