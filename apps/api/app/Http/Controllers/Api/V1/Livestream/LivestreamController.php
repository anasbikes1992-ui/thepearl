<?php

namespace App\Http\Controllers\Api\V1\Livestream;

use App\Http\Controllers\Controller;
use App\Models\Livestream\Livestream;
use App\Models\Livestream\LivestreamMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LivestreamController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Livestream::query()->latest()->paginate(20),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'vertical' => ['required', 'string', 'max:64'],
            'starts_at' => ['nullable', 'date'],
        ]);

        $stream = Livestream::query()->create([
            'provider_user_id' => auth()->id(),
            'title' => $validated['title'],
            'vertical' => $validated['vertical'],
            'status' => 'scheduled',
            'starts_at' => $validated['starts_at'] ?? null,
            'stream_key' => Str::random(36),
        ]);

        return response()->json(['data' => $stream], 201);
    }

    public function chat(Request $request, Livestream $livestream): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'min:1', 'max:1000'],
        ]);

        $chat = LivestreamMessage::query()->create([
            'livestream_id' => $livestream->id,
            'user_id' => auth()->id(),
            'message' => $validated['message'],
        ]);

        return response()->json(['data' => $chat], 201);
    }
}
