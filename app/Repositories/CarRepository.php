<?php

namespace App\Repositories;

use App\Models\Car;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Collection;

class CarRepository implements CarRepositoryInterface
{
    public function all(int $userId): Collection
    {
        return Car::query()->where('user_id', $userId)->orderByDesc('created_at')->get();
    }

    public function find(int $id): Car
    {
        return Car::findOrFail($id);
    }

    public function create(array $carData): Car
    {
        return Car::create($carData);
    }

    public function delete(int $id): void
    {
        $this->find($id)->delete();
    }

    public function recalculateTotalMiles(int $id): void
    {
        $car = $this->find($id);

        $car->total_miles = $car->trips->reduce(function (float $carry, Trip $trip) {
            return $carry + $trip->miles;
        }, 0);

        $car->save();
    }
}
