<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;

class AiConciergeService
{
    public function chat(string $message, string $locale): array
    {
        $openAiKey = config('services.openai.key');

        if (!empty($openAiKey)) {
            $response = Http::withToken($openAiKey)
                ->timeout(15)
                ->post('https://api.openai.com/v1/responses', [
                    'model' => 'gpt-4o-mini',
                    'input' => sprintf('Locale: %s. User: %s', $locale, $message),
                ]);

            if ($response->ok()) {
                return [
                    'provider' => 'openai',
                    'reply' => $response->json('output.0.content.0.text') ?? 'How can I help with your booking today?',
                ];
            }
        }

        return [
            'provider' => 'fallback',
            'reply' => 'Concierge is ready. Tell me your city, budget, and service type and I will suggest instant options.',
        ];
    }
}
