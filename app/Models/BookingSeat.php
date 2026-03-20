<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['booking_id', 'flight_id', 'seat_config_id', 'passenger_id', 'class_type', 'price', 'ticket_number', 'eticket_path'])]
class BookingSeat extends Model
{
    use HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }
    
    public function getEticketUrlAttribute(): ?string
    {
        return $this->eticket_path
            ? asset('storage/' . $this->eticket_path)
            : null;
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function flight(): BelongsTo
    {
        return $this->belongsTo(Flight::class);
    }

    public function seatConfiguration(): BelongsTo
    {
        return $this->belongsTo(SeatConfiguration::class, 'seat_config_id');
    }

    public function passenger(): BelongsTo
    {
        return $this->belongsTo(Passenger::class);
    }
}
