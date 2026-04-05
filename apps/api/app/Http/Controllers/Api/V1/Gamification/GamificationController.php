<?php

namespace App\Http\Controllers\Api\V1\Gamification;

use App\Http\Controllers\Controller;
use App\Models\Gamification\Badge;
use App\Models\Gamification\UserBadge;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GamificationController extends Controller
{
    public function badges(): JsonResponse
    {
        return response()->json(['data' => Badge::query()->get()]);
    }

    public function award(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'badge_id' => ['required', 'uuid'],
            'user_id' => ['required', 'uuid'],
        ]);

        $award = UserBadge::query()->firstOrCreate([
            'user_id' => $validated['user_id'],
            'badge_id' => $validated['badge_id'],
        ], [
            'awarded_at' => now(),
        ]);

        return response()->json(['data' => $award], 201);
    }
}
