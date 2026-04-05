<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResaleListing extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'provider_user_id',
        'vertical',
        'title',
        'condition_grade',
        'price',
        'currency',
        'status',
        'metadata',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'metadata' => 'array',
    ];
}
