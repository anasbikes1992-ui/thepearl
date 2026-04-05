<?php

namespace App\Models\Academy;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCourseProgress extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'user_id',
        'course_id',
        'completion_percent',
        'completed_at',
    ];

    protected $casts = [
        'completion_percent' => 'decimal:2',
        'completed_at' => 'datetime',
    ];
}
