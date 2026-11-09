<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use App\Models\Weblog;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
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
