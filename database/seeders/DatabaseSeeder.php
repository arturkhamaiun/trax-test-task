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
        Car::factory()
            ->count(5)
            ->for(User::factory()->create([
                'name' => 'Test Test',
                'email' => 'test@test.com',
            ]))
            ->has(Trip::factory()->count(5))
            ->create();
    }
}
