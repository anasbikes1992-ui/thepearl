<?php

namespace App\Http\Controllers\Api\V1\Providers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Providers\UpdateProviderProfileRequest;
use App\Models\ProviderProfile;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ProviderProfileController extends Controller
{
    public function show(User $provider): JsonResponse
    {
        $profile = ProviderProfile::query()->where('user_id', $provider->id)->first();
        $reviewAggregate = [
            'rating_average' => round((float) $provider->receivedReviews()->avg('rating'), 1),
            'rating_count' => $provider->receivedReviews()->count(),
        ];

        return response()->json([
            'provider' => $provider,
            'profile' => $profile,
            'reviews' => $reviewAggregate,
        ]);
    }

    public function upsert(UpdateProviderProfileRequest $request): JsonResponse
    {
        $profile = ProviderProfile::query()->updateOrCreate(
            ['user_id' => auth()->id()],
            $request->validated()
        );

        return response()->json(['data' => $profile]);
    }
}