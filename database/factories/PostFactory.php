<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'content' => fake()->paragraphs(5,true),
            'meta_description' => fake()->shuffleArray(),
            'featured_image' => fake()->imageUrl(),
            'is_featured' => fake()->boolean(20),
            'is_published' => fake()->boolean(80),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
