<?php

namespace App\Repositories;

use App\Models\Car;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CarRepository implements CarRepositoryInterface
{
    public function all(): Collection
    {
        return Car::query()->orderByDesc('created_at')->get();
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

        $car->total_miles = $car->trips->reduce(function (int $carry, Trip $trip) {
            return $carry + $trip->miles;
        }, 0);

        $car->save();
    }
}
