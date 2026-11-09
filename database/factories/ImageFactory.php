<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Weblog;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'weblog_id' => Weblog::factory(),
            'url' => 'weblogs/' . fake()->uuid() . '.jpg',
            'alt_text' => fake()->sentence(),
            'uploaded_at' => now(),
        ];
    }
}
