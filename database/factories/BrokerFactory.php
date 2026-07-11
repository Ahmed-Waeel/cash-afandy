<?php

namespace Database\Factories;

use App\Models\Broker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Broker>
 */
class BrokerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->company(),
            'email' => $this->faker->unique()->companyEmail(),
            'phone' => $this->faker->phoneNumber(),
            'url' => $this->faker->url(),
        ];
    }
}
