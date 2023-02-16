<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class TripsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->withHeader('Accept', 'application/json');
    }

    public function testListTrips()
    {
        $user = User::factory()->create();

        Passport::actingAs($user);

        Car::factory()
            ->has(Trip::factory(5))
            ->for($user)
            ->createOne();


        $response = $this->get(route('trips.index'));

        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
        $response->assertJsonStructure([
            'data' => [
                [
                    'id' ,
                    'date',
                    'miles',
                    'total',
                    'car' => [
                        'id',
                        'make',
                        'model',
                        'year',
                    ]
                ]
            ],
        ]);
    }

    public function testStoreTrip()
    {
        $user = User::factory()->create();

        Passport::actingAs($user);

        $car = Car::factory()->for($user)->createOne();

        $params = [
            'car_id' => $car->id,
            'date' => '2023-02-15',
            'miles' => 1,
        ];

        $response = $this->post(route('trips.index'), $params);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id' ,
                'date',
                'miles',
                'total',
                'car' => [
                    'id',
                    'make',
                    'model',
                    'year',
                ]
            ],
        ]);
        $this->assertDatabaseHas(Trip::class, $params);
    }
}
