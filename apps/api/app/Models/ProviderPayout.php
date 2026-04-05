<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderPayout extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'provider_id',
        'escrow_transaction_id',
        'amount',
        'currency',
        'status',
        'settled_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'settled_at' => 'datetime',
    ];
}
