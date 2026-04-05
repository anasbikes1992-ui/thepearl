<?php

namespace App\Http\Controllers\Api\V1\Payments;

use App\Jobs\ProcessPaymentWebhookJob;
use App\Http\Controllers\Controller;
use App\Models\Payments\PaymentWebhookEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentWebhookController extends Controller
{
    public function handleStripe(Request $request): JsonResponse
    {
        return $this->capture('stripe', $request, $request->header('Stripe-Signature'));
    }

    public function handlePayHere(Request $request): JsonResponse
    {
        return $this->capture('payhere', $request, $request->header('X-PayHere-Signature'));
    }

    private function capture(string $provider, Request $request, ?string $signature): JsonResponse
    {
        $payload = $request->all();
        $eventId = (string) ($payload['id'] ?? $payload['event_id'] ?? $payload['payment_id'] ?? 'unknown');
        $eventType = (string) ($payload['type'] ?? $payload['status'] ?? 'unknown');

        $event = PaymentWebhookEvent::query()->firstOrCreate(
            [
                'provider' => $provider,
                'event_id' => $eventId,
            ],
            [
                'event_type' => $eventType,
                'status' => 'received',
                'signature' => $signature,
                'payload' => $payload,
                'processed_at' => now(),
            ]
        );

        if ($event->wasRecentlyCreated) {
            ProcessPaymentWebhookJob::dispatch($event->id);
        }

        return response()->json([
            'accepted' => true,
            'idempotent' => !$event->wasRecentlyCreated,
            'event_id' => $eventId,
        ]);
    }
}