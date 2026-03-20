<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'flight_id',
    'class_type',
    'base_price',
    'extra_legroom_fee',
])]

class FlightSeatPrice extends Model
{
    use HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'base_price'        => 'decimal:2',
            'extra_legroom_fee' => 'decimal:2',
        ];
    }

    public function getTotalPriceAttribute(): float
    {
        return $this->base_price + $this->extra_legroom_fee;
    }

    public function flight(): BelongsTo
    {
        return $this->belongsTo(Flight::class);
    }
}
