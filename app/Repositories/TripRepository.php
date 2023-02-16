<?php

namespace App\Repositories;

use App\Models\Car;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

class TripRepository implements TripRepositoryInterface
{
    public function __construct(
        public CarRepositoryInterface $carRepository,
    ) {
    }

    public function all(): Collection
    {
        $result = DB::table('trips')
            ->select(
                'trips.*',
                'cars.id as car.id',
                'cars.make as car.make',
                'cars.model as car.model',
                'cars.year as car.year',
            )
            ->join('cars', 'cars.id', '=', 'trips.car_id')
            ->orderByDesc('trips.created_at')
            ->get()
            ->map(fn (stdClass $item) => Arr::undot((array)$item))
            ->toArray();

        $trips = Trip::query()
            ->hydrate($result)
            ->each(fn (Trip $trip) => $trip->car = new Car($trip->car));

        return $trips;
    }

    public function create(array $tripData): Trip
    {
        $tripData['date'] = Carbon::parse($tripData['date']);

        return DB::transaction(function () use ($tripData) {
            // Do I need lock??

            $previousTrip = Trip::query()->latest()->first();
            $tripData['total_miles'] = $tripData['miles'] + ($previousTrip?->total_miles ?? 0);

            $trip = Trip::create($tripData);

            $this->carRepository->recalculateTotalMiles($trip->car_id);

            return $trip;
        });
    }
}
