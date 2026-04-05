<?php

namespace App\Models\Academy;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseLesson extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'course_id',
        'title',
        'position',
        'video_url',
        'content',
    ];
}
