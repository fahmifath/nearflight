<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['name', 'iata_code', 'logo_url', 'is_active'])]
class Airplane extends Model
{
    use HasFactory, HasUuids;


    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function airline(): BelongsTo
    {
        return $this->belongsTo(Airline::class);
    }

    public function flights(): HasMany
    {
        return $this->hasMany(Flight::class);
    }
}
