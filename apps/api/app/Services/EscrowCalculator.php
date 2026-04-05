<?php

namespace App\Services;

class EscrowCalculator
{
    /**
     * @return array<string, float>
     */
    public function breakdown(float $gross, float $commissionRate, float $escrowFeeRate): array
    {
        $commissionAmount = round($gross * $commissionRate, 2);
        $escrowFeeAmount = round($gross * $escrowFeeRate, 2);
        $providerNetAmount = round($gross - $commissionAmount - $escrowFeeAmount, 2);

        return [
            'gross_amount' => $gross,
            'commission_amount' => $commissionAmount,
            'escrow_fee_amount' => $escrowFeeAmount,
            'provider_net_amount' => $providerNetAmount,
        ];
    }
}
