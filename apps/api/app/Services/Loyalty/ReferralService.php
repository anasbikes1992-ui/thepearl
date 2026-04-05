<?php

namespace App\Services\Loyalty;

use App\Models\ReferralLedger;
use App\Models\User;

class ReferralService
{
    public function rewardFirstTransaction(User $referrer, User $referred, string $transactionId): ReferralLedger
    {
        return ReferralLedger::query()->create([
            'referrer_user_id' => $referrer->id,
            'referred_user_id' => $referred->id,
            'trigger_transaction_id' => $transactionId,
            'points_awarded_referrer' => 500,
            'points_awarded_referred' => 250,
            'status' => 'awarded',
            'metadata' => [
                'rule' => 'first_completed_transaction',
                'anti_abuse' => 'kyc_unique_identity',
            ],
        ]);
    }
}
