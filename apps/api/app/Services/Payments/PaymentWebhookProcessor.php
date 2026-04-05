<?php

namespace App\Services\Payments;

use App\Models\Payments\PaymentWebhookEvent;
use App\Services\Platform\PlatformEventRecorder;

class PaymentWebhookProcessor
{
    public function __construct(private readonly PlatformEventRecorder $recorder)
    {
    }

    public function process(PaymentWebhookEvent $event): PaymentWebhookEvent
    {
        if ($event->status === 'processed') {
            return $event;
        }

        $this->recorder->record(
            'payment_webhook',
            $event->id,
            'payment_webhook.processed',
            [
                'provider' => $event->provider,
                'event_id' => $event->event_id,
                'event_type' => $event->event_type,
            ]
        );

        $event->update([
            'status' => 'processed',
            'processed_at' => now(),
        ]);

        return $event->fresh();
    }
}
