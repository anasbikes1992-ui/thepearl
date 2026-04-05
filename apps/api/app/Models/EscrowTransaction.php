<?php

namespace App\Models;

use App\Enums\EscrowStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscrowTransaction extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'booking_id',
        'customer_id',
        'provider_id',
        'gross_amount',
        'commission_rate',
        'escrow_fee_rate',
        'commission_amount',
        'escrow_fee_amount',
        'provider_net_amount',
        'currency',
        'status',
        'auto_release_at',
        'released_at',
        'metadata',
    ];

    protected $casts = [
        'gross_amount' => 'decimal:2',
        'commission_rate' => 'decimal:4',
        'escrow_fee_rate' => 'decimal:4',
        'commission_amount' => 'decimal:2',
        'escrow_fee_amount' => 'decimal:2',
        'provider_net_amount' => 'decimal:2',
        'auto_release_at' => 'datetime',
        'released_at' => 'datetime',
        'metadata' => 'array',
        'status' => EscrowStatus::class,
    ];
}
