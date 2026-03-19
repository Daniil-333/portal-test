<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = Category::all()->pluck('id', 'id')->toArray();

        $title = fake()->name();
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'short_desc' => fake()->sentence(7),
            'description' => fake()->text(100),
            'category_id' => array_rand($categories)
        ];
    }
}
