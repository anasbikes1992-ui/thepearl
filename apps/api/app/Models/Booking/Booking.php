<?php

namespace App\Models\Booking;

use App\Enums\Booking\BookingStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'listing_id',
        'customer_id',
        'provider_id',
        'starts_at',
        'ends_at',
        'quantity',
        'subtotal',
        'discount_amount',
        'total_amount',
        'currency',
        'status',
        'metadata',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'metadata' => 'array',
        'status' => BookingStatus::class,
    ];
}
