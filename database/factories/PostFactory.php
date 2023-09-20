<?php

namespace Database\Factories;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' =>fake()->sentence(),
            'description' => fake()->paragraph(),
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Post $post) {
            $tags = Tag::inRandomOrder()->limit(2)->get();
            $post->tags()->attach($tags);
        });
    }
}
