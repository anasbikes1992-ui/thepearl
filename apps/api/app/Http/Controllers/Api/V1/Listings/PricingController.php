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
        ]);

        return response()->json([
            'data' => $service->estimate(
                $validated['vertical'],
                (float) $validated['base_price'],
                $validated['district']
            ),
        ]);
    }
}
