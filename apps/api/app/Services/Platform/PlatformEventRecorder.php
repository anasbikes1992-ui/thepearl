<?php

namespace App\Services\Platform;

use App\Models\PlatformEvent;

class PlatformEventRecorder
{
    public function record(string $aggregateType, string $aggregateId, string $eventName, array $payload = [], int $version = 1): PlatformEvent
    {
        return PlatformEvent::query()->create([
            'aggregate_type' => $aggregateType,
            'aggregate_id' => $aggregateId,
            'event_name' => $eventName,
            'event_version' => $version,
            'payload' => $payload,
            'occurred_at' => now(),
        ]);
    }
}
