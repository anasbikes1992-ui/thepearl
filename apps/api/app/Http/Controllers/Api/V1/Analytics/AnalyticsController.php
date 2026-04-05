<?php

namespace App\Http\Controllers\Api\V1\Analytics;

use App\Http\Controllers\Controller;
use App\Models\Booking\Booking;
use App\Models\EscrowTransaction;
use App\Models\Listing\Listing;
use Illuminate\Http\JsonResponse;

class AnalyticsController extends Controller
{
    public function overview(): JsonResponse
    {
        $gmv = (float) Booking::query()->sum('total_amount');
        $take = (float) EscrowTransaction::query()->sum('commission_amount');

        return response()->json([
            'gmv' => $gmv,
            'platform_take' => $take,
            'listings_total' => Listing::query()->count(),
            'bookings_total' => Booking::query()->count(),
            'active_escrows' => EscrowTransaction::query()->where('status', 'held')->count(),
        ]);
    }
}
