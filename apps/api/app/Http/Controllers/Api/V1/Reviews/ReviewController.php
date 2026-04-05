<?php

namespace App\Http\Controllers\Api\V1\Reviews;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reviews\StoreReviewRequest;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    public function index(User $provider): JsonResponse
    {
        return response()->json([
            'data' => Review::query()
                ->where('provider_user_id', $provider->id)
                ->latest()
                ->paginate(20),
        ]);
    }

    public function store(StoreReviewRequest $request): JsonResponse
    {
        $review = Review::query()->create([
            ...$request->validated(),
            'reviewer_user_id' => auth()->id(),
            'is_verified' => filled($request->validated('booking_id')),
        ]);

        return response()->json(['data' => $review], 201);
    }
}