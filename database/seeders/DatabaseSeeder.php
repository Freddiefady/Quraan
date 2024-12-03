<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
            SheikhsSeeder::class,
            RatingSeeder::class,
            ArticlesSeeder::class,
            CommentSeeder::class,
            ContactSeeder::class,
            DemoModelSeeder::class,
            BooksSeeder::class,
            CourseSeeder::class,
            ReadsSeeder::class,
            NovelSeeder::class,
        ]);
    }
}
