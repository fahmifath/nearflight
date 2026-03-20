<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'airline_id',
    'airplane_id',
    'origin_airport_id',
    'destination_airport_id',
    'flight_number',
    'departure_at',
    'arrival_at',
    'status',
])]

class Flight extends Model
{
    use HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'departure_at' => 'datetime',
            'arrival_at'   => 'datetime',
        ];
    }

    public function getDurationAttribute(): string
    {
        $diff = $this->departure_at->diff($this->arrival_at);
        return $diff->h . 'j ' . $diff->i . 'm';
    }

    public function isAvailable(): bool
    {
        return in_array($this->status, ['scheduled', 'boarding']);
    }

    public function airline(): BelongsTo
    {
        return $this->belongsTo(Airline::class);
    }

    public function airplane(): BelongsTo
    {
        return $this->belongsTo(Airplane::class);
    }

    public function originAirport(): BelongsTo
    {
        return $this->belongsTo(Airport::class, 'origin_airport_id');
    }

    public function destinationAirport(): BelongsTo
    {
        return $this->belongsTo(Airport::class, 'destination_airport_id');
    }

    public function seatPrices(): HasMany
    {
        return $this->hasMany(FlightSeatPrice::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function bookingSeats(): HasMany
    {
        return $this->hasMany(BookingSeat::class);
    }
}
