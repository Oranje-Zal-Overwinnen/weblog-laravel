<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Weblog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Weblog>
 */
class WeblogFactory extends Factory
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
            'title' => Str::title(fake()->unique()->words(3, true)),
            'text' => fake()->paragraphs(3, true),
            'is_premium' => false,
            'published_at' => fake()->dateTimeBetween('-1 year'),
        ];
    }

    /**
     * Indicate that the article is premium content.
     */
    public function premium(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_premium' => true,
        ]);
    }
}
