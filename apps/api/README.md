# @pearlhub/api

Laravel 11 API for PearlHub 2.0 using modular monolith boundaries.

## Setup

1. `composer install`
2. `cp .env.example .env`
3. `php artisan key:generate`
4. `php artisan migrate --seed`
5. `php artisan serve`

## Core Modules

- Identity and KYC
- Listings and moderation
- Bookings and escrow
- Loyalty and referrals
- Concierge AI orchestration
- Provider profiles and trust signals
- Review aggregation
- Payment webhook capture and idempotency groundwork
- Disputes, payout settlement, and reconciliation
- Agentic concierge memory and voice commerce
- Social graph, livestream, academy, gamification
- Resale and sustainability scoring
- GraphQL readiness endpoint and platform event store foundations

## Key Routes (v1)

- `GET /listings`
- `POST /listings`
- `POST /listings/{listing}/submit-review`
- `POST /listings/{listing}/moderate`
- `POST /bookings`
- `POST /bookings/{booking}/complete`
- `POST /pricing/estimate`
- `POST /concierge/chat`
- `GET /loyalty/me`
- `GET /analytics/overview`
- `GET /providers/{provider}`
- `GET /providers/{provider}/reviews`
- `PUT /provider-profile`
- `POST /reviews`
- `POST /kyc/events`
- `POST /payments/webhooks/stripe`
- `POST /payments/webhooks/payhere`
- `POST /escrow/disputes`
- `POST /escrow/disputes/{dispute}/resolve`
- `POST /escrow/payouts/queue`
- `POST /escrow/payouts/{payout}/settle`
- `GET /escrow/reconciliation/summary`
- `POST /escrow/{escrow}/signals`
- `POST /concierge/agentic-chat`
- `POST /concierge/convert`
- `POST /voice/transcribe`
- `POST /voice/concierge`
- `POST /bundles/compose`
- `GET /trust/score/{user}`
- `GET /providers/os/dashboard`
- `GET /market-playbooks?city={city}&vertical={vertical}`
- `POST /social/follow`
- `POST /social/unfollow`
- `GET /livestreams`
- `POST /livestreams`
- `POST /livestreams/{livestream}/chat`
- `GET /academy/courses`
- `POST /academy/progress`
- `GET /gamification/badges`
- `POST /gamification/award`
- `GET /resale/listings`
- `POST /resale/listings`
- `POST /resale/sustainability-badges`
- `POST /graphql`

## Phase 6 Delivered

- Bootable Laravel runtime entry files (`artisan`, `bootstrap/app.php`, `public/index.php`)
- Core config for app, auth, database, cache, queue, session, filesystems, and CORS
- Provider profile domain + migration
- Review domain + migration
- KYC verification event audit trail + migration
- Payment webhook event ledger + idempotent capture controller
