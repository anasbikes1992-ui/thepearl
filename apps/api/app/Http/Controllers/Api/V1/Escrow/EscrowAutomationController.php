<?php

namespace App\Http\Controllers\Api\V1\Escrow;

use App\Http\Controllers\Controller;
use App\Models\EscrowTransaction;
use App\Services\Finance\EscrowAutomationService;
use App\Services\Platform\PlatformEventRecorder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EscrowAutomationController extends Controller
{
    public function applySignals(
        Request $request,
        EscrowTransaction $escrow,
        EscrowAutomationService $service,
        PlatformEventRecorder $recorder
    ): JsonResponse {
        $validated = $request->validate([
            'check_in_verified' => ['nullable', 'boolean'],
            'qr_proof' => ['nullable', 'boolean'],
            'geofence_verified' => ['nullable', 'boolean'],
            'otp_verified' => ['nullable', 'boolean'],
            'provider_acknowledged' => ['nullable', 'boolean'],
        ]);

        $result = $service->applySignals($escrow, $validated);

        $recorder->record('escrow_transaction', $escrow->id, 'escrow.signals_applied', [
            'released' => $result['released'],
            'signals' => $result['signals'],
        ]);

        if ($result['released']) {
            $recorder->record('escrow_transaction', $escrow->id, 'escrow.smart_auto_released', [
                'reason' => 'objective_signals_threshold_met',
                'booking_id' => $escrow->booking_id,
            ]);
        }

        return response()->json(['data' => $result]);
    }
}
