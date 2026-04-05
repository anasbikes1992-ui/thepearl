<?php

namespace App\Services\Finance;

use App\Enums\EscrowStatus;
use App\Models\Dispute;
use App\Models\EscrowTransaction;
use App\Services\Platform\PlatformEventRecorder;

class DisputeResolutionService
{
    public function __construct(private readonly PlatformEventRecorder $recorder)
    {
    }

    public function open(string $bookingId, string $openedByUserId, string $reason): Dispute
    {
        $escrow = EscrowTransaction::query()->where('booking_id', $bookingId)->firstOrFail();

        $escrow->update(['status' => EscrowStatus::InDispute]);

        $dispute = Dispute::query()->create([
            'booking_id' => $bookingId,
            'escrow_transaction_id' => $escrow->id,
            'opened_by_user_id' => $openedByUserId,
            'status' => 'open',
            'reason' => $reason,
        ]);

        $this->recorder->record('dispute', $dispute->id, 'dispute.opened', [
            'booking_id' => $bookingId,
            'escrow_transaction_id' => $escrow->id,
        ]);

        return $dispute;
    }

    public function resolve(Dispute $dispute, string $decision, float $providerShare): Dispute
    {
        $escrow = EscrowTransaction::query()->findOrFail($dispute->escrow_transaction_id);

        $gross = (float) $escrow->gross_amount;
        $providerAmount = round($gross * max(min($providerShare, 1), 0), 2);
        $customerRefund = round($gross - $providerAmount, 2);

        $escrow->update([
            'status' => $decision === 'refund' ? EscrowStatus::Refunded : EscrowStatus::Released,
            'released_at' => now(),
            'metadata' => array_merge($escrow->metadata ?? [], [
                'dispute_resolution' => [
                    'decision' => $decision,
                    'provider_amount' => $providerAmount,
                    'customer_refund' => $customerRefund,
                ],
            ]),
        ]);

        $dispute->update([
            'status' => 'resolved',
            'resolution' => [
                'decision' => $decision,
                'provider_amount' => $providerAmount,
                'customer_refund' => $customerRefund,
                'resolved_at' => now()->toISOString(),
            ],
        ]);

        $this->recorder->record('dispute', $dispute->id, 'dispute.resolved', [
            'decision' => $decision,
            'provider_share' => $providerShare,
        ]);

        return $dispute->fresh();
    }
}
