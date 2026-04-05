<?php

namespace App\Http\Controllers\Api\V1\Voice;

use App\Http\Controllers\Controller;
use App\Services\AI\AgenticConciergeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VoiceCommerceController extends Controller
{
    public function transcribe(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'transcript' => ['required', 'string', 'min:2', 'max:3000'],
            'locale' => ['required', 'in:en,si,ta'],
        ]);

        return response()->json([
            'transcript' => $validated['transcript'],
            'locale' => $validated['locale'],
            'provider' => 'voice-gateway-placeholder',
        ]);
    }

    public function concierge(Request $request, AgenticConciergeService $service): JsonResponse
    {
        $validated = $request->validate([
            'transcript' => ['required', 'string', 'min:2', 'max:3000'],
            'locale' => ['required', 'in:en,si,ta'],
        ]);

        return response()->json($service->respond((string) auth()->id(), $validated['transcript'], $validated['locale'], 'voice'));
    }
}
