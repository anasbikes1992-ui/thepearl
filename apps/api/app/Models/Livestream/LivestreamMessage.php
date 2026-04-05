<?php

namespace App\Models\Livestream;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LivestreamMessage extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'livestream_id',
        'user_id',
        'message',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];
}
