<?php

namespace App\Services\Finance;

use App\Enums\EscrowStatus;
use App\Models\Dispute;
use App\Models\EscrowTransaction;
use Illuminate\Support\Facades\DB;

class EscrowAutomationService
{
    public function applySignals(EscrowTransaction $escrow, array $signals): array
    {
        return DB::transaction(function () use ($escrow, $signals): array {
            $lockedEscrow = EscrowTransaction::query()
                ->whereKey($escrow->id)
                ->lockForUpdate()
                ->firstOrFail();

            $metadata = $lockedEscrow->metadata ?? [];
            $metadata['completion_signals'] = array_merge($metadata['completion_signals'] ?? [], [
                'check_in_verified' => (bool) ($signals['check_in_verified'] ?? false),
                'qr_proof' => (bool) ($signals['qr_proof'] ?? false),
                'geofence_verified' => (bool) ($signals['geofence_verified'] ?? false),
                'otp_verified' => (bool) ($signals['otp_verified'] ?? false),
                'provider_acknowledged' => (bool) ($signals['provider_acknowledged'] ?? false),
                'captured_at' => now()->toIso8601String(),
            ]);

            $canAutoRelease = $this->canAutoRelease($lockedEscrow, $metadata['completion_signals']);

            $lockedEscrow->update([
                'metadata' => $metadata,
                'status' => $canAutoRelease ? EscrowStatus::Released : $lockedEscrow->status,
                'released_at' => $canAutoRelease ? now() : $lockedEscrow->released_at,
            ]);

            return [
                'released' => $canAutoRelease,
                'status' => $lockedEscrow->fresh()->status->value,
                'signals' => $metadata['completion_signals'],
                'reason' => $canAutoRelease
                    ? 'Auto-release criteria met from objective completion signals.'
                    : 'Escrow held: insufficient completion signals or active dispute.',
            ];
        });
    }

    private function canAutoRelease(EscrowTransaction $escrow, array $signals): bool
    {
        if ($escrow->status !== EscrowStatus::Held) {
            return false;
        }

        $hasBlockingDispute = Dispute::query()
            ->where('escrow_transaction_id', $escrow->id)
            ->whereNotIn('status', ['resolved', 'closed'])
            ->exists();

        if ($hasBlockingDispute) {
            return false;
        }

        $objectiveProofs = [
            !empty($signals['check_in_verified']),
            !empty($signals['qr_proof']),
            !empty($signals['geofence_verified']),
            !empty($signals['otp_verified']),
        ];

        $proofCount = collect($objectiveProofs)->filter(fn (bool $value): bool => $value)->count();

        return $proofCount >= 2;
    }
}
