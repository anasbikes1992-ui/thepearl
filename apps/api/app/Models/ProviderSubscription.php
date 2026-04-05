<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderSubscription extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'provider_id',
        'tier',
        'monthly_price',
        'commission_discount_rate',
        'starts_at',
        'ends_at',
        'status',
    ];

    protected $casts = [
        'monthly_price' => 'decimal:2',
        'commission_discount_rate' => 'decimal:4',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];
}
