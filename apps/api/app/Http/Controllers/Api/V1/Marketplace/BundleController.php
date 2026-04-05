<?php

namespace App\Http\Controllers\Api\V1\Marketplace;

use App\Http\Controllers\Controller;
use App\Services\Marketplace\BundleComposerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BundleController extends Controller
{
    public function compose(Request $request, BundleComposerService $service): JsonResponse
    {
        $validated = $request->validate([
            'city' => ['nullable', 'string', 'max:120'],
            'district' => ['nullable', 'string', 'max:120'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'vertical_targets' => ['nullable', 'array'],
            'vertical_targets.*' => ['string'],
        ]);

        return response()->json([
            'data' => $service->compose($validated),
        ]);
    }
}
