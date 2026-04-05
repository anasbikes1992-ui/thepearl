<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatformEvent extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'aggregate_type',
        'aggregate_id',
        'event_name',
        'event_version',
        'payload',
        'occurred_at',
    ];

    protected $casts = [
        'event_version' => 'integer',
        'payload' => 'array',
        'occurred_at' => 'datetime',
    ];
}
