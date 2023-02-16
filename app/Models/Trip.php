<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
}
