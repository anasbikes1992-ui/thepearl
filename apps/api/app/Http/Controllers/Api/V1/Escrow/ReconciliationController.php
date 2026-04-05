<?php

namespace App\Http\Controllers\Api\V1\Escrow;

use App\Http\Controllers\Controller;
use App\Models\EscrowTransaction;
use App\Models\ProviderPayout;
use Illuminate\Http\JsonResponse;

class ReconciliationController extends Controller
{
    public function summary(): JsonResponse
    {
        return response()->json([
            'escrow_held_total' => (float) EscrowTransaction::query()->where('status', 'held')->sum('gross_amount'),
            'escrow_released_total' => (float) EscrowTransaction::query()->where('status', 'released')->sum('gross_amount'),
            'payout_pending_total' => (float) ProviderPayout::query()->where('status', 'pending_settlement')->sum('amount'),
            'payout_settled_total' => (float) ProviderPayout::query()->where('status', 'settled')->sum('amount'),
        ]);
    }
}
