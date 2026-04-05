<?php

namespace App\Models\Academy;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'audience',
        'is_published',
        'metadata',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'metadata' => 'array',
    ];
}
