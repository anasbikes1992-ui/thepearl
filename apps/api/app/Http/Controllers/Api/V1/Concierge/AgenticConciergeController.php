<?php

namespace App\Http\Controllers\Api\V1\Concierge;

use App\Http\Controllers\Controller;
use App\Services\AI\AgenticConciergeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AgenticConciergeController extends Controller
{
    public function chat(Request $request, AgenticConciergeService $service): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'min:2', 'max:2000'],
            'locale' => ['required', 'in:en,si,ta'],
            'channel' => ['nullable', 'in:text,voice'],
        ]);

        $result = $service->respond(
            (string) auth()->id(),
            $validated['message'],
            $validated['locale'],
            (string) ($validated['channel'] ?? 'text')
        );

        return response()->json($result);
    }
}
