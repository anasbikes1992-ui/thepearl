<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SustainabilityBadge extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'provider_user_id',
        'badge_type',
        'score',
        'issued_at',
        'metadata',
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'issued_at' => 'datetime',
        'metadata' => 'array',
    ];
}
