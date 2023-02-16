<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTripRequest;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use App\Repositories\TripRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TripController extends Controller
{
    public function __construct(
        public TripRepositoryInterface $tripRepository,
    ) {
    }

    /**
     * Display trips listing.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Trip::class);

        return TripResource::collection($this->tripRepository->all($request->user()->id));
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
