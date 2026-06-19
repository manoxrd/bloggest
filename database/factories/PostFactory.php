<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

use function Laravel\Prompts\number;

/**
 * @extends Factory<Post>
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
            'user_id' => User::factory(),
            'thumbnail' => fake()->text(10),
            'title' => fake()->title(),
            'slug' => fake()->unique()->uuid(), 
            'body' => fake()->text(),
            'likes_count' => fake()->randomNumber(),
            'views_count' => fake()->randomNumber()
        ];
    }
}
