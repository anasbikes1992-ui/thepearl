<?php

namespace App\Http\Controllers\Api\V1\Resale;

use App\Http\Controllers\Controller;
use App\Models\ResaleListing;
use App\Models\SustainabilityBadge;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResaleController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => ResaleListing::query()->where('status', 'published')->paginate(20),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'vertical' => ['required', 'string', 'max:64'],
            'title' => ['required', 'string', 'max:180'],
            'condition_grade' => ['required', 'string', 'max:20'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
        ]);

        $listing = ResaleListing::query()->create([
            ...$validated,
            'provider_user_id' => auth()->id(),
            'status' => 'draft',
        ]);

        return response()->json(['data' => $listing], 201);
    }

    public function sustainabilityBadge(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'provider_user_id' => ['required', 'uuid'],
            'badge_type' => ['required', 'string', 'max:80'],
            'score' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $badge = SustainabilityBadge::query()->create([
            ...$validated,
            'issued_at' => now(),
        ]);

        return response()->json(['data' => $badge], 201);
    }
}
