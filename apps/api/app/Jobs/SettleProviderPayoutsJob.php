<?php

namespace App\Jobs;

use App\Models\ProviderPayout;
use App\Services\Finance\PayoutSettlementService;
use App\Services\Platform\PlatformEventRecorder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SettleProviderPayoutsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function handle(PayoutSettlementService $service, PlatformEventRecorder $recorder): void
    {
        ProviderPayout::query()
            ->where('status', 'pending_settlement')
            ->chunkById(50, function ($payouts) use ($service, $recorder): void {
                foreach ($payouts as $payout) {
                    $settled = $service->settle($payout);
                    $recorder->record('provider_payout', $settled->id, 'payout.settled', [
                        'provider_id' => $settled->provider_id,
                        'amount' => $settled->amount,
                    ]);
                }
            }, 'id');
    }
}
