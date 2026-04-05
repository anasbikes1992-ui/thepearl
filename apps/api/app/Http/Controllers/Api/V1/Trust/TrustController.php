<?php

namespace App\Http\Controllers\Api\V1\Trust;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Trust\TrustGraphService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrustController extends Controller
{
    public function score(Request $request, User $user, TrustGraphService $service): JsonResponse
    {
        if ($request->user()?->id !== $user->id) {
            abort(403, 'You are not authorized to view this trust score.');
        }

        return response()->json([
            'data' => $service->scoreUser($user),
        ]);
    }
}
