<?php

namespace App\Http\Controllers\Api\V1\Escrow;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use App\Services\Finance\DisputeResolutionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DisputeController extends Controller
{
    public function store(Request $request, DisputeResolutionService $service): JsonResponse
    {
        $validated = $request->validate([
            'booking_id' => ['required', 'uuid'],
            'reason' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        $dispute = $service->open(
            $validated['booking_id'],
            (string) auth()->id(),
            $validated['reason']
        );

        return response()->json(['data' => $dispute], 201);
    }

    public function resolve(Request $request, Dispute $dispute, DisputeResolutionService $service): JsonResponse
    {
        $validated = $request->validate([
            'decision' => ['required', 'in:release,refund,split'],
            'provider_share' => ['required', 'numeric', 'min:0', 'max:1'],
        ]);

        $resolved = $service->resolve($dispute, $validated['decision'], (float) $validated['provider_share']);

        return response()->json(['data' => $resolved]);
    }
}
