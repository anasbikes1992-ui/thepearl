<?php

namespace App\Jobs;

use App\Models\Payments\PaymentWebhookEvent;
use App\Services\Payments\PaymentWebhookProcessor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessPaymentWebhookJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public string $webhookEventId)
    {
    }

    public function handle(PaymentWebhookProcessor $processor): void
    {
        $event = PaymentWebhookEvent::query()->find($this->webhookEventId);

        if ($event) {
            $processor->process($event);
        }
    }
}
