<?php

use App\Models\Car;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $firstUser = User::factory()->create([
            'name' => 'First User',
            'email' => 'first@example.com',
        ]);

        User::factory()->create([
            'name' => 'Second User',
            'email' => 'second@example.com',
        ]);

        $cars = [
            ['Land Rover', 'Range Rover Sport'],
            ['Aston Martin', 'Vanquish'],
            ['Ford', 'F150'],
            ['Chevy', 'Tahoe'],
            ['Tesla', 'Model X'],
        ];

        foreach ($cars as $car) {
            [$make, $model] = $car;

            Car::factory()->for($firstUser)->create([
                'make' => $make,
                'model' => $model
            ]);
        }
    }
}
