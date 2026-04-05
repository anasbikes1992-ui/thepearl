<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'code',
        'name',
        'domain',
        'status',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];
}
