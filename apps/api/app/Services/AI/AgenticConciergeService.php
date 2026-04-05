<?php

namespace App\Services\AI;

use App\Models\AiConversation;
use App\Models\AiConversationMessage;

class AgenticConciergeService
{
    public function respond(string $userId, string $message, string $locale, string $channel = 'text'): array
    {
        $conversation = AiConversation::query()->firstOrCreate(
            ['user_id' => $userId, 'channel' => $channel],
            ['locale' => $locale, 'context' => ['tools' => []], 'last_message_at' => now()]
        );

        AiConversationMessage::query()->create([
            'conversation_id' => $conversation->id,
            'role' => 'user',
            'content' => $message,
            'metadata' => ['locale' => $locale],
        ]);

        $intent = $this->inferIntent($message);
        $toolPlan = $this->toolPlanForIntent($intent);

        $reply = match ($intent) {
            'cross_vertical_trip' => 'I can plan stays, vehicles, and activities together. Share city and dates to proceed.',
            'booking_status' => 'I can check your booking and escrow status now. Please provide booking reference.',
            default => 'Tell me what you want to book and your budget, and I will build a complete plan.',
        };

        AiConversationMessage::query()->create([
            'conversation_id' => $conversation->id,
            'role' => 'assistant',
            'content' => $reply,
            'metadata' => ['intent' => $intent, 'tool_plan' => $toolPlan],
        ]);

        $conversation->update([
            'last_message_at' => now(),
            'context' => array_merge($conversation->context ?? [], [
                'last_intent' => $intent,
                'last_tool_plan' => $toolPlan,
            ]),
        ]);

        return [
            'conversation_id' => $conversation->id,
            'intent' => $intent,
            'tool_plan' => $toolPlan,
            'reply' => $reply,
        ];
    }

    private function inferIntent(string $message): string
    {
        $normalized = strtolower($message);

        if (str_contains($normalized, 'trip') || str_contains($normalized, 'family') || str_contains($normalized, 'tour')) {
            return 'cross_vertical_trip';
        }

        if (str_contains($normalized, 'status') || str_contains($normalized, 'escrow')) {
            return 'booking_status';
        }

        return 'general_discovery';
    }

    /**
     * @return list<string>
     */
    private function toolPlanForIntent(string $intent): array
    {
        return match ($intent) {
            'cross_vertical_trip' => ['search_listings', 'check_availability', 'build_quote'],
            'booking_status' => ['lookup_booking', 'lookup_escrow'],
            default => ['search_listings'],
        };
    }
}
