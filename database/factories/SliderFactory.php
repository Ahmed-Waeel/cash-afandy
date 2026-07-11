<?php

namespace Database\Factories;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Slider>
 */
class SliderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'locale' => $this->faker->randomElement(setting('website_locales')),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->optional()->paragraphs(2, true),
            'foreground' => '#ffffff',
            'background' => '#00000080',
            'background_size' => $this->faker->randomElement(['cover', 'contain']),
            'image' => 'https://placehold.co/1920x1080.png',
            'buttons' => $this->faker->optional()->passthrough([
                [
                    'type' => $this->faker->randomElement(['primary', 'secondary', 'success', 'danger', 'warning', 'info']),
                    'label' => $this->faker->words(2, true),
                    'url' => $this->faker->url(),
                ],
            ]),
            'active' => $this->faker->boolean(),
        ];
    }
}
