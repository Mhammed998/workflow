<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
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
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'category_id' => rand(0, 9),
            'image_path' => 'articles/post_image.png',
            'date' => now(),
            'views' => rand(0, 1000),
            'show_on_hero' => rand(0, 1),
            'is_featured' => rand(0, 1),
            'is_breaking' => rand(0, 1)
        ];
    }
}
