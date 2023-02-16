<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTripRequest;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use App\Repositories\TripRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TripController extends Controller
{
    public function __construct(
        protected TripRepositoryInterface $tripRepository,
    ) {
    }

    /**
     * Display trips listing.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Trip::class);

        return TripResource::collection($this->tripRepository->all($request->user()->id));
    }

    /**
     * Store a newly created trip in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTripRequest $request): JsonResponse
    {
        $this->authorize('create', [Trip::class, $request->car_id]);

        $trip = $this->tripRepository->create($request->validated());

        return TripResource::make($trip)->response()->setStatusCode(201);
    }
}
