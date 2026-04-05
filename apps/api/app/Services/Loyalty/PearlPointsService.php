<?php

namespace App\Services\Loyalty;

use App\Models\User;

class PearlPointsService
{
    public function award(User $user, int $points, string $reason): void
    {
        $user->increment('pearl_points', $points);

        // Phase 4: persist immutable points ledger table for finance-grade audit.
        logger()->info('pearl_points_awarded', [
            'user_id' => $user->id,
            'points' => $points,
            'reason' => $reason,
        ]);
    }
}
