<?php

namespace App\Jobs;

use App\Enums\Booking\BookingStatus;
use App\Enums\EscrowStatus;
use App\Models\Booking\Booking;
use App\Models\EscrowTransaction;
use App\Services\Platform\PlatformEventRecorder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AutoReleaseEscrowJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function handle(PlatformEventRecorder $recorder): void
    {
        EscrowTransaction::query()
            ->where('status', EscrowStatus::Held)
            ->whereNotNull('auto_release_at')
            ->where('auto_release_at', '<=', now())
            ->chunkById(50, function ($escrows) use ($recorder): void {
                foreach ($escrows as $escrow) {
                    $escrow->update([
                        'status' => EscrowStatus::Released,
                        'released_at' => now(),
                    ]);

                    Booking::query()->whereKey($escrow->booking_id)->update([
                        'status' => BookingStatus::Completed,
                    ]);

                    $recorder->record('escrow_transaction', $escrow->id, 'escrow.auto_released', [
                        'booking_id' => $escrow->booking_id,
                        'provider_id' => $escrow->provider_id,
                    ]);
                }
            }, 'id');
    }
}
