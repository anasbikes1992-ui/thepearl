<?php

namespace App\Services\Finance;

use App\Enums\EscrowStatus;
use App\Models\EscrowTransaction;
use App\Models\ProviderPayout;

class PayoutSettlementService
{
    public function queueEligiblePayouts(): int
    {
        $eligibleEscrows = EscrowTransaction::query()
            ->where('status', EscrowStatus::Released)
            ->whereNotNull('released_at')
            ->get();

        $count = 0;

        foreach ($eligibleEscrows as $escrow) {
            ProviderPayout::query()->firstOrCreate(
                ['escrow_transaction_id' => $escrow->id],
                [
                    'provider_id' => $escrow->provider_id,
                    'amount' => $escrow->provider_net_amount,
                    'currency' => $escrow->currency,
                    'status' => 'pending_settlement',
                ]
            );
            $count++;
        }

        return $count;
    }

    public function settle(ProviderPayout $payout): ProviderPayout
    {
        $payout->update([
            'status' => 'settled',
            'settled_at' => now(),
        ]);

        return $payout->fresh();
    }
}
