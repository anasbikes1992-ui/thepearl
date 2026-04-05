<?php

namespace App\Services\Trust;

use App\Models\Dispute;
use App\Models\KycVerificationEvent;
use App\Models\Review;
use App\Models\User;

class TrustGraphService
{
    public function scoreUser(User $user): array
    {
        $avgRating = (float) Review::query()->where('provider_user_id', $user->id)->avg('rating');
        $reviewCount = Review::query()->where('provider_user_id', $user->id)->count();

        $disputeCount = Dispute::query()
            ->whereIn('booking_id', $user->providerBookings()->select('id'))
            ->count();

        $kycApproved = KycVerificationEvent::query()
            ->where('user_id', $user->id)
            ->where('status', 'approved')
            ->exists();

        $bookingVolume = $user->providerBookings()->count() + $user->customerBookings()->count();

        $ratingSignal = $reviewCount > 0 ? (($avgRating / 5) * 35) : 20;
        $volumeSignal = min(25, $bookingVolume * 0.5);
        $kycSignal = $kycApproved ? 20 : 8;
        $disputePenalty = min(25, $disputeCount * 4.5);

        $trustScore = max(1, min(100, round($ratingSignal + $volumeSignal + $kycSignal - $disputePenalty, 1)));
        $riskScore = round(100 - $trustScore, 1);

        return [
            'user_id' => $user->id,
            'trust_score' => $trustScore,
            'risk_score' => $riskScore,
            'risk_band' => $this->riskBand($riskScore),
            'signals' => [
                'avg_rating' => round($avgRating, 2),
                'review_count' => $reviewCount,
                'dispute_count' => $disputeCount,
                'kyc_approved' => $kycApproved,
                'booking_volume' => $bookingVolume,
            ],
        ];
    }

    private function riskBand(float $riskScore): string
    {
        return match (true) {
            $riskScore >= 70 => 'high',
            $riskScore >= 40 => 'medium',
            default => 'low',
        };
    }
}
