<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTripRequest;
use App\Http\Resources\TripResource;
use App\Models\Car;
use App\Models\Trip;
use App\Repositories\TripRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use stdClass;

class TripController extends Controller
{
    public function __construct(
        public TripRepositoryInterface $tripRepository,
    ) {
    }

    /**
     * Display trips listing.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Trip::class);

        return TripResource::collection($this->tripRepository->all());
    }

    /**
     * Store a newly created trip in storage.
     *
     * @param  \App\Http\Requests\StoreTripRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTripRequest $request)
    {
        $this->authorize('create', [Trip::class, $request->car_id]);

        $trip = $this->tripRepository->create($request->validated());

        return TripResource::make($trip)->response()->setStatusCode(201);
    }
}
