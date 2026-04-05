<?php

namespace App\Http\Controllers\Api\V1\Concierge;

use App\Http\Controllers\Controller;
use App\Services\AI\ConciergeConversionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConciergeConversionController extends Controller
{
    public function convert(Request $request, ConciergeConversionService $service): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'min:2', 'max:2000'],
            'locale' => ['required', 'in:en,si,ta'],
            'city' => ['nullable', 'string', 'max:120'],
            'district' => ['nullable', 'string', 'max:120'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'vertical_targets' => ['nullable', 'array'],
            'vertical_targets.*' => ['string'],
        ]);

        return response()->json([
            'data' => $service->convert($validated),
        ]);
    }
}
