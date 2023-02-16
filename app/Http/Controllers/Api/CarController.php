<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Repositories\CarRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CarController extends Controller
{
    public function __construct(
        protected CarRepositoryInterface $carRepository,
    ) {
    }

    /**
     * Display cars listing.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Car::class);

        return CarResource::collection($this->carRepository->all($request->user()->id));
    }

    /**
     * Store a newly created car in storage.
     *
     * @param \App\Http\Requests\StoreCarRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCarRequest $request)
    {
        $this->authorize('create', Car::class);

        $carData = array_merge($request->validated(), ['user_id' => $request->user()->id]);
        $car = $this->carRepository->create($carData);

        return CarResource::make($car)->response()->setStatusCode(201);
    }

    /**
     * Display car.
     *
     * @param  Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $car = $this->carRepository->find($id);

        $this->authorize('view', $car);

        return CarResource::make($car);
    }

    /**
     * Remove car from storage.
     *
     * @param  Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $car = $this->carRepository->find($id);

        $this->authorize('delete', $car);

        $this->carRepository->delete($id);

        return response(null, 204);
    }
}
