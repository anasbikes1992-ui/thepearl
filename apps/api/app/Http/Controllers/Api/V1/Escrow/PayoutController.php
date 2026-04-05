<?php

namespace App\Http\Controllers\Api\V1\Escrow;

use App\Http\Controllers\Controller;
use App\Models\ProviderPayout;
use App\Services\Finance\PayoutSettlementService;
use Illuminate\Http\JsonResponse;

class PayoutController extends Controller
{
    public function queue(PayoutSettlementService $service): JsonResponse
    {
        $count = $service->queueEligiblePayouts();

        return response()->json(['queued' => $count]);
    }

    public function settle(ProviderPayout $payout, PayoutSettlementService $service): JsonResponse
    {
        return response()->json(['data' => $service->settle($payout)]);
    }
}
