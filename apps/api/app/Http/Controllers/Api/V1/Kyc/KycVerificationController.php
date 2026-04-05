<?php

namespace App\Http\Controllers\Api\V1\Kyc;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kyc\StoreKycVerificationEventRequest;
use App\Models\KycVerificationEvent;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class KycVerificationController extends Controller
{
    public function store(StoreKycVerificationEventRequest $request): JsonResponse
    {
        $event = KycVerificationEvent::query()->create([
            ...$request->validated(),
            'actor_user_id' => auth()->id(),
        ]);

        User::query()->whereKey($request->validated('user_id'))->update([
            'kyc_status' => $request->validated('status'),
        ]);

        return response()->json(['data' => $event], 201);
    }
}