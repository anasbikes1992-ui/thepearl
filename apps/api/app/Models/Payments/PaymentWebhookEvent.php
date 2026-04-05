<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentWebhookEvent extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'provider',
        'event_id',
        'event_type',
        'status',
        'signature',
        'payload',
        'processed_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'processed_at' => 'datetime',
    ];
}