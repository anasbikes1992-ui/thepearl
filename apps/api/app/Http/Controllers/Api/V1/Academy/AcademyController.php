<?php

namespace App\Http\Controllers\Api\V1\Academy;

use App\Http\Controllers\Controller;
use App\Models\Academy\Course;
use App\Models\Academy\UserCourseProgress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AcademyController extends Controller
{
    public function courses(): JsonResponse
    {
        return response()->json([
            'data' => Course::query()->where('is_published', true)->paginate(20),
        ]);
    }

    public function updateProgress(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'course_id' => ['required', 'uuid'],
            'completion_percent' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $progress = UserCourseProgress::query()->updateOrCreate(
            ['user_id' => auth()->id(), 'course_id' => $validated['course_id']],
            [
                'completion_percent' => $validated['completion_percent'],
                'completed_at' => (float) $validated['completion_percent'] >= 100 ? now() : null,
            ]
        );

        return response()->json(['data' => $progress]);
    }
}
