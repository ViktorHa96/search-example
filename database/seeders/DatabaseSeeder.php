<?php

namespace Database\Seeders;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::factory(10)->create();
        Tag::factory(30)->create();
        Post::factory(100)->create();
    }
}
