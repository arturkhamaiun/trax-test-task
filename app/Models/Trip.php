<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trip extends Model
{
    use HasFactory;

    protected $casts = [
        'date' => 'date:m/d/Y',
    ];

    protected $fillable = [
        'date',
        'car_id',
        'miles',
        'total_miles',
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function scopeBelongsToUser(Builder $query, int $userId): Builder
    {
        return $query->whereHas('car', fn (Builder $q) => $q->where('user_id', $userId));
    }
}
