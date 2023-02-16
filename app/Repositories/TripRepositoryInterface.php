<?php

namespace App\Repositories;

use App\Models\Trip;
use Illuminate\Database\Eloquent\Collection;

interface TripRepositoryInterface
{
    public function all(int $userId): Collection;
    public function create(array $tripData): Trip;
}
