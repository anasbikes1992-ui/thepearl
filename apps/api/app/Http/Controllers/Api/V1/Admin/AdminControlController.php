<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\BusinessControlService;
use App\Services\Analytics\GodViewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminControlController extends Controller
{
    public function godView(Request $request, GodViewService $service): JsonResponse
    {
        $this->authorizeAdmin($request);

        return response()->json([
            'data' => $service->build(),
        ]);
    }

    public function controls(Request $request, BusinessControlService $service): JsonResponse
    {
        $this->authorizeAdmin($request);

        return response()->json([
            'data' => $service->getControls(),
        ]);
    }

    public function updateControls(Request $request, BusinessControlService $service): JsonResponse
    {
        $this->authorizeAdmin($request);

        $validated = $request->validate([
            'commission_overrides' => ['nullable', 'array'],
            'commission_overrides.*' => ['nullable', 'numeric', 'min:0.04', 'max:0.25'],
            'referral_bonus_points_referrer' => ['nullable', 'integer', 'min:50', 'max:10000'],
            'referral_bonus_points_referred' => ['nullable', 'integer', 'min:50', 'max:10000'],
            'referral_multiplier' => ['nullable', 'numeric', 'min:0.1', 'max:3.0'],
        ]);

        return response()->json([
            'data' => $service->updateControls($validated),
        ]);
    }

    private function authorizeAdmin(Request $request): void
    {
        $user = $request->user();

        if (!$user || !$user->hasAnyRole(['admin', 'super-admin'])) {
            abort(403, 'Admin privileges required.');
        }
    }
}
