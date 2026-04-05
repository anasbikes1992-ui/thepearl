<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderProfile extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'user_id',
        'business_name',
        'verticals',
        'bio',
        'phone',
        'website_url',
        'facebook_url',
        'instagram_url',
        'is_verified',
        'supports_livestream',
        'supports_resale',
        'sustainability_score',
        'metadata',
    ];

    protected $casts = [
        'verticals' => 'array',
        'is_verified' => 'boolean',
        'supports_livestream' => 'boolean',
        'supports_resale' => 'boolean',
        'sustainability_score' => 'decimal:2',
        'metadata' => 'array',
    ];
}