<?php

namespace App\Services\AI;

use App\Services\Marketplace\BundleComposerService;
use Illuminate\Support\Facades\Log;

class ConciergeConversionService
{
    public function __construct(
        private readonly AiConciergeService $concierge,
        private readonly BundleComposerService $bundles
    ) {
    }

    public function convert(array $payload): array
    {
        try {
            $reply = $this->concierge->chat((string) $payload['message'], (string) $payload['locale']);
        } catch (\Throwable $exception) {
            Log::warning('Concierge conversion fallback triggered due to chat provider failure.', [
                'error' => $exception->getMessage(),
            ]);

            $reply = [
                'reply' => 'I am having trouble responding instantly right now. I can still prepare a bundle for you.',
                'provider' => 'fallback',
            ];
        }

        $bundle = $this->bundles->compose([
            'city' => $payload['city'] ?? null,
            'district' => $payload['district'] ?? null,
            'budget' => (float) ($payload['budget'] ?? 0),
            'vertical_targets' => $payload['vertical_targets'] ?? null,
        ]);

        return [
            'assistant' => $reply,
            'bundle_offer' => $bundle,
            'next_best_action' => count($bundle['items']) > 0
                ? 'Proceed to checkout with escrow protection and 15-minute inventory lock.'
                : 'Refine constraints to unlock an instant bundle offer.',
        ];
    }
}
