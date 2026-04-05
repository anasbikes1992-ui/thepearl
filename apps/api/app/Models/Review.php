<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'reviewer_user_id',
        'provider_user_id',
        'booking_id',
        'rating',
        'title',
        'body',
        'is_verified',
        'metadata',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'is_verified' => 'boolean',
        'metadata' => 'array',
    ];
}