<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use App\Models\Weblog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'weblog_id' => Weblog::factory(),
            'user_id' => User::factory(),
            'text' => fake()->sentence(),
            'published_at' => now(),
        ];
    }
}
