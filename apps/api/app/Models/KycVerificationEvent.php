<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KycVerificationEvent extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'user_id',
        'actor_user_id',
        'provider',
        'event_type',
        'status',
        'notes',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}