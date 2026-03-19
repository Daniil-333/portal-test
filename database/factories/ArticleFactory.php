<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Video>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->name();
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'read_time' => fake()->numberBetween(1, 255),
            'short_desc' => fake()->sentence(7),
            'description' => fake()->text(100),
        ];
    }
}
