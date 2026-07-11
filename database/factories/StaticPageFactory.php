<?php

namespace Database\Factories;

use App\Models\StaticPage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Factory<StaticPage>
 */
class StaticPageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = StaticPage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $data = [
            'title' => [],
            'content' => [],
        ];

        foreach (array_keys(config('app.locales')) as $locale) {
            $data['title'][$locale] = $this->faker->sentence(3);
            $data['content'][$locale] = $this->faker->paragraphs(3, true);
        }

        return $data;
    }
}
