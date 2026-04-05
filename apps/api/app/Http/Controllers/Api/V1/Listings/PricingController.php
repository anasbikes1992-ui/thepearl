<?php

namespace App\Http\Controllers\Api\V1\Listings;

use App\Http\Controllers\Controller;
use App\Services\AI\PriceEstimatorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function estimate(Request $request, PriceEstimatorService $service): JsonResponse
    {
        $validated = $request->validate([
            'vertical' => ['required', 'string'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'district' => ['required', 'string'],
            'demand_index' => ['nullable', 'numeric', 'min:0', 'max:1'],
            'seasonality' => ['nullable', 'in:peak,normal,off_peak'],
            'weather' => ['nullable', 'string', 'max:40'],
            'local_event_count' => ['nullable', 'integer', 'min:0', 'max:20'],
            'provider_score' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        return response()->json([
            'data' => $service->estimate(
                $validated['vertical'],
                (float) $validated['base_price'],
                $validated['district'],
                [
                    'demand_index' => $validated['demand_index'] ?? null,
                    'seasonality' => $validated['seasonality'] ?? null,
                    'weather' => $validated['weather'] ?? null,
                    'local_event_count' => $validated['local_event_count'] ?? null,
                    'provider_score' => $validated['provider_score'] ?? null,
                ]
            ),
        ]);
    }
}
