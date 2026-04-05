<?php

namespace App\Models\Listing;

use App\Enums\Listing\ListingStatus;
use App\Enums\Listing\Vertical;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'provider_id',
        'vertical',
        'title',
        'slug',
        'description',
        'base_price',
        'currency',
        'district',
        'city',
        'latitude',
        'longitude',
        'status',
        'is_featured',
        'metadata',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'is_featured' => 'boolean',
        'metadata' => 'array',
        'status' => ListingStatus::class,
        'vertical' => Vertical::class,
    ];
}
