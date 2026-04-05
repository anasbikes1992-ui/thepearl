<?php

namespace App\Http\Controllers\Api\V1\Listings;

use App\Enums\Listing\ListingStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Listings\StoreListingRequest;
use App\Models\Listing\Listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ListingController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Listing::query()->where('status', ListingStatus::Published->value);

        if ($vertical = $request->query('vertical')) {
            $query->where('vertical', $vertical);
        }

        if ($district = $request->query('district')) {
            $query->where('district', $district);
        }

        return response()->json([
            'data' => $query->latest()->paginate(20),
        ]);
    }

    public function store(StoreListingRequest $request): JsonResponse
    {
        $this->authorize('create', Listing::class);

        $payload = $request->validated();
        $payload['provider_id'] = auth()->id();
        $payload['status'] = ListingStatus::Draft->value;
        $payload['slug'] = Str::slug($payload['title']) . '-' . Str::lower(Str::random(8));

        $listing = Listing::query()->create($payload);

        return response()->json(['data' => $listing], 201);
    }

    public function submitForReview(Listing $listing): JsonResponse
    {
        $this->authorize('update', $listing);

        $listing->update(['status' => ListingStatus::Pending->value]);

        return response()->json(['data' => $listing->fresh()]);
    }

    public function moderate(Request $request, Listing $listing): JsonResponse
    {
        $this->authorize('moderate', $listing);

        $validated = $request->validate([
            'decision' => ['required', 'in:publish,reject'],
        ]);

        $listing->update([
            'status' => $validated['decision'] === 'publish'
                ? ListingStatus::Published->value
                : ListingStatus::Rejected->value,
        ]);

        return response()->json(['data' => $listing->fresh()]);
    }
}
