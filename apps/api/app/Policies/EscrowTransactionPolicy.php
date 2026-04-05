<?php

namespace App\Policies;

use App\Models\EscrowTransaction;
use App\Models\User;

class EscrowTransactionPolicy
{
    public function view(User $user, EscrowTransaction $escrow): bool
    {
        if ($user->hasAnyRole(['admin', 'super-admin'])) {
            return true;
        }

        return $escrow->customer_id === $user->id || $escrow->provider_id === $user->id;
    }

    public function openDispute(User $user, EscrowTransaction $escrow): bool
    {
        return $this->view($user, $escrow) && $escrow->status->value === 'held';
    }
}
