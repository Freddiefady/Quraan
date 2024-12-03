<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Articles;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = Articles::factory()->count(20)->create();
        $articles -> each(function($articles): void{
            Image::factory(2)->create([
                'articles_id'=>$articles->id,
            ]);
        });
    }
}
