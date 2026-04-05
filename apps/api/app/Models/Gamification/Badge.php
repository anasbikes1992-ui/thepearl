<?php

namespace App\Models\Gamification;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'code',
        'name',
        'description',
        'points_reward',
        'metadata',
    ];

    protected $casts = [
        'points_reward' => 'integer',
        'metadata' => 'array',
    ];
}
