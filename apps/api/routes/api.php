<?php

use App\Http\Controllers\Api\V1\Analytics\AnalyticsController;
use App\Http\Controllers\Api\V1\Academy\AcademyController;
use App\Http\Controllers\Api\V1\Bookings\BookingController;
use App\Http\Controllers\Api\V1\Concierge\AgenticConciergeController;
use App\Http\Controllers\Api\V1\Concierge\ConciergeController;
use App\Http\Controllers\Api\V1\Concierge\ConciergeConversionController;
use App\Http\Controllers\Api\V1\Escrow\EscrowAutomationController;
use App\Http\Controllers\Api\V1\Escrow\DisputeController;
use App\Http\Controllers\Api\V1\Escrow\PayoutController;
use App\Http\Controllers\Api\V1\Escrow\ReconciliationController;
use App\Http\Controllers\Api\V1\Gamification\GamificationController;
use App\Http\Controllers\Api\V1\Graphql\GraphqlController;
use App\Http\Controllers\Api\V1\Kyc\KycVerificationController;
use App\Http\Controllers\Api\V1\Livestream\LivestreamController;
use App\Http\Controllers\Api\V1\Listings\ListingController;
use App\Http\Controllers\Api\V1\Listings\PricingController;
use App\Http\Controllers\Api\V1\LoyaltyController;
use App\Http\Controllers\Api\V1\Marketplace\BundleController;
use App\Http\Controllers\Api\V1\Marketplace\MarketPlaybookController;
use App\Http\Controllers\Api\V1\Payments\PaymentWebhookController;
use App\Http\Controllers\Api\V1\Providers\ProviderProfileController;
use App\Http\Controllers\Api\V1\Providers\ProviderOperatingSystemController;
use App\Http\Controllers\Api\V1\Resale\ResaleController;
use App\Http\Controllers\Api\V1\Reviews\ReviewController;
use App\Http\Controllers\Api\V1\Social\SocialController;
use App\Http\Controllers\Api\V1\Trust\TrustController;
use App\Http\Controllers\Api\V1\Voice\VoiceCommerceController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::middleware('throttle:90,1')->group(function (): void {
        Route::get('/listings', [ListingController::class, 'index']);
        Route::get('/providers/{provider}', [ProviderProfileController::class, 'show']);
        Route::get('/providers/{provider}/reviews', [ReviewController::class, 'index']);
        Route::get('/livestreams', [LivestreamController::class, 'index']);
        Route::get('/academy/courses', [AcademyController::class, 'courses']);
        Route::get('/gamification/badges', [GamificationController::class, 'badges']);
        Route::get('/resale/listings', [ResaleController::class, 'index']);
        Route::get('/market-playbooks', [MarketPlaybookController::class, 'show']);
        Route::post('/graphql', [GraphqlController::class, 'handle']);
    });

    Route::middleware('throttle:120,1')->group(function (): void {
        Route::post('/payments/webhooks/stripe', [PaymentWebhookController::class, 'handleStripe']);
        Route::post('/payments/webhooks/payhere', [PaymentWebhookController::class, 'handlePayHere']);
    });

    Route::middleware(['auth:sanctum', 'throttle:180,1'])->group(function (): void {
        Route::post('/listings', [ListingController::class, 'store']);
        Route::post('/listings/{listing}/submit-review', [ListingController::class, 'submitForReview']);
        Route::post('/listings/{listing}/moderate', [ListingController::class, 'moderate']);

        Route::put('/provider-profile', [ProviderProfileController::class, 'upsert']);
        Route::post('/reviews', [ReviewController::class, 'store']);
        Route::post('/kyc/events', [KycVerificationController::class, 'store']);
        Route::post('/social/follow', [SocialController::class, 'follow']);
        Route::post('/social/unfollow', [SocialController::class, 'unfollow']);

        Route::post('/livestreams', [LivestreamController::class, 'store']);
        Route::post('/livestreams/{livestream}/chat', [LivestreamController::class, 'chat']);

        Route::post('/academy/progress', [AcademyController::class, 'updateProgress']);
        Route::post('/gamification/award', [GamificationController::class, 'award']);

        Route::post('/resale/listings', [ResaleController::class, 'store']);
        Route::post('/resale/sustainability-badges', [ResaleController::class, 'sustainabilityBadge']);

        Route::post('/bookings', [BookingController::class, 'store']);
        Route::post('/bookings/{booking}/complete', [BookingController::class, 'complete']);
        Route::post('/escrow/disputes', [DisputeController::class, 'store']);
        Route::post('/escrow/disputes/{dispute}/resolve', [DisputeController::class, 'resolve']);
        Route::post('/escrow/payouts/queue', [PayoutController::class, 'queue']);
        Route::post('/escrow/payouts/{payout}/settle', [PayoutController::class, 'settle']);
        Route::post('/escrow/{escrow}/signals', [EscrowAutomationController::class, 'applySignals']);
        Route::get('/escrow/reconciliation/summary', [ReconciliationController::class, 'summary']);

        Route::post('/pricing/estimate', [PricingController::class, 'estimate']);
        Route::post('/bundles/compose', [BundleController::class, 'compose']);

        Route::get('/loyalty/me', [LoyaltyController::class, 'me']);
        Route::post('/concierge/chat', [ConciergeController::class, 'chat']);
        Route::post('/concierge/agentic-chat', [AgenticConciergeController::class, 'chat']);
        Route::post('/concierge/convert', [ConciergeConversionController::class, 'convert']);
        Route::post('/voice/transcribe', [VoiceCommerceController::class, 'transcribe']);
        Route::post('/voice/concierge', [VoiceCommerceController::class, 'concierge']);
        Route::get('/trust/score/{user}', [TrustController::class, 'score']);
        Route::get('/providers/os/dashboard', [ProviderOperatingSystemController::class, 'dashboard']);

        Route::get('/analytics/overview', [AnalyticsController::class, 'overview']);
    });
});
