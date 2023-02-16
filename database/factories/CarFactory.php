<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'year' => $this->faker->year,
            'make' => $this->faker->word,
            'model' => $this->faker->word,
            'total_miles' => 0,
            'user_id' => function (array $attributes) {
                return (int)$attributes['user_id'] ?? User::factory()->create()->id;
            },
        ];
    }
}
