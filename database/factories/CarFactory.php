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
        $cars = [
            ['Land Rover', 'Range Rover Sport'],
            ['Aston Martin', 'Vanquish'],
            ['Ford', 'F150'],
            ['Chevy', 'Tahoe'],
            ['Tesla', 'Model X'],
        ];

        [$make, $model] = $cars[array_rand($cars)];

        return [
            'year' => $this->faker->year,
            'make' => $make,
            'model' => $model,
            'total_miles' => $this->faker->randomFloat(1, 1, 100),
            'user_id' => function (array $attributes) {
                return (int)$attributes['user_id'] ?? User::factory()->create()->id;
            },
        ];
    }
}
