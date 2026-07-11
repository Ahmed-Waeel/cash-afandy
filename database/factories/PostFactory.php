<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

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
            'slug' => $this->faker->unique()->slug(),
            'title' => $this->faker->sentence(),
            'locale' => $this->faker->randomElement(['en', 'ar']),
            'category_id' => fn () => Arr::random(array_merge([null], Category::pluck('id')->all())),
            'excerpt' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(3, true),
            'cover_image' => $this->faker->imageUrl(),
            'media_type' => null,
            'media' => null,
            'tags' => $this->faker->words(3),
            'published_at' => $this->faker->optional()->dateTimeBetween('-1 year', '+1 month'),
        ];
    }
}
