<?php

namespace App\Http\Controllers\Api\V1\Concierge;

use App\Http\Controllers\Controller;
use App\Services\AI\AiConciergeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConciergeController extends Controller
{
    public function chat(Request $request, AiConciergeService $service): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'min:2', 'max:2000'],
            'locale' => ['required', 'in:en,si,ta'],
        ]);

        $result = $service->chat($validated['message'], $validated['locale']);

        return response()->json([
            'reply' => $result['reply'],
            'provider' => $result['provider'],
            'input' => $validated,
        ]);
    }
}
