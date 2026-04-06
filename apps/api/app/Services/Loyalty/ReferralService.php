<?php

namespace App\Services\Loyalty;

use App\Models\ReferralLedger;
use App\Models\User;
use App\Services\Admin\BusinessControlService;

class ReferralService
{
    public function __construct(private readonly BusinessControlService $businessControls)
    {
    }

    public function rewardFirstTransaction(User $referrer, User $referred, string $transactionId): ReferralLedger
    {
        $referrerPoints = $this->businessControls->referralBonusPoints('referrer');
        $referredPoints = $this->businessControls->referralBonusPoints('referred');

        return ReferralLedger::query()->create([
            'referrer_user_id' => $referrer->id,
            'referred_user_id' => $referred->id,
            'trigger_transaction_id' => $transactionId,
            'points_awarded_referrer' => $referrerPoints,
            'points_awarded_referred' => $referredPoints,
            'status' => 'awarded',
            'metadata' => [
                'rule' => 'first_completed_transaction',
                'anti_abuse' => 'kyc_unique_identity',
                'dynamic_bonus' => true,
            ],
        ]);
    }
}
