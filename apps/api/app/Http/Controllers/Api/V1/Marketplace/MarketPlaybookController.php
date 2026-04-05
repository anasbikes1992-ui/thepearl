<?php

namespace App\Http\Controllers\Api\V1\Marketplace;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MarketPlaybookController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'city' => ['required', 'string', 'max:120'],
            'vertical' => ['required', 'string', 'max:80'],
        ]);

        $playbooks = config('vertical_playbooks', []);
        $cityKey = strtolower($validated['city']);
        $verticalKey = strtolower($validated['vertical']);

        $playbook = $playbooks[$cityKey][$verticalKey] ?? [
            'supply_mix' => 'balanced',
            'pricing_band' => ['min' => null, 'recommended' => null, 'max' => null],
            'sla' => ['response_minutes' => 30, 'fulfillment_hours' => 24],
            'notes' => 'No tuned playbook yet. Start with balanced supply and monitor conversion and disputes weekly.',
        ];

        return response()->json([
            'data' => [
                'city' => $validated['city'],
                'vertical' => $validated['vertical'],
                'playbook' => $playbook,
            ],
        ]);
    }
}
