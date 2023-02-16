<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date,
            'car_id' => function (array $attributes) {
                return (int)$attributes['car_id'] ?? Car::factory()->create()->id;
            },
            'miles' => $this->faker->randomFloat(1, 1, 100),
            'total_miles' => $this->faker->randomFloat(1, 100, 1000),
        ];
    }
}
