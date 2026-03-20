<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'created_by',
    'code',
    'type',
    'value',
    'min_purchase',
    'max_discount',
    'max_uses',
    'used_count',
    'applicable_class',
    'valid_from',
    'valid_until',
    'is_active',
])]

class DiscountCode extends Model
{
    use HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'value'        => 'decimal:2',
            'min_purchase' => 'decimal:2',
            'max_discount' => 'decimal:2',
            'valid_from'   => 'datetime',
            'valid_until'  => 'datetime',
            'is_active'    => 'boolean',
        ];
    }

    public function isValid(): bool
    {
        $now = now();

        return $this->is_active
            && $now->between($this->valid_from, $this->valid_until)
            && ($this->max_uses === null || $this->used_count < $this->max_uses);
    }

    public function calculateDiscount(float $subtotal): float
    {
        if ($subtotal < $this->min_purchase) {
            return 0;
        }

        $discount = $this->type === 'percentage'
            ? $subtotal * ($this->value / 100)
            : $this->value;

        if ($this->max_discount !== null) {
            $discount = min($discount, $this->max_discount);
        }

        return round($discount, 2);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
