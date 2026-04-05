<?php

namespace App\Http\Controllers\Api\V1\Social;

use App\Http\Controllers\Controller;
use App\Models\Social\SocialFollow;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function follow(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'following_user_id' => ['required', 'uuid'],
        ]);

        $follow = SocialFollow::query()->firstOrCreate([
            'follower_user_id' => auth()->id(),
            'following_user_id' => $validated['following_user_id'],
        ]);

        return response()->json(['data' => $follow], 201);
    }

    public function unfollow(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'following_user_id' => ['required', 'uuid'],
        ]);

        SocialFollow::query()
            ->where('follower_user_id', auth()->id())
            ->where('following_user_id', $validated['following_user_id'])
            ->delete();

        return response()->json(['ok' => true]);
    }
}
