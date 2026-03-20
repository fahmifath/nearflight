<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'airplane_id',
    'seat_number',
    'class_type',
    'is_window',
    'is_aisle',
    'has_extra_legroom',
])]

class SeatConfiguration extends Model
{
    use HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'is_window'         => 'boolean',
            'is_aisle'          => 'boolean',
            'has_extra_legroom' => 'boolean',
        ];
    }


    public function airplane(): BelongsTo
    {
        return $this->belongsTo(Airplane::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'seat_config_id');
    }

    public function bookingSeats(): HasMany
    {
        return $this->hasMany(BookingSeat::class, 'seat_config_id');
    }
}
