<?php

namespace App\Repositories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Collection;

interface CarRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): Car;
    public function create(array $carData): Car;
    public function delete(int $id): void;
    public function recalculateTotalMiles(int $id): void;
}
