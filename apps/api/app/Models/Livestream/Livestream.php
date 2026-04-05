<?php

namespace App\Models\Livestream;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livestream extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'provider_user_id',
        'title',
        'vertical',
        'status',
        'starts_at',
        'ended_at',
        'stream_key',
        'viewer_count',
        'metadata',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ended_at' => 'datetime',
        'viewer_count' => 'integer',
        'metadata' => 'array',
    ];
}
