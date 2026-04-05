# System Overview

## Architectural Style

PearlHub 2.0 uses a modular monolith API with explicit bounded contexts and strict access boundaries, paired with a Next.js web frontend and three Flutter clients.

## Bounded Contexts (API)

- Identity & Access (users, roles, KYC, sessions)
- Listings (7 vertical-specific aggregates)
- Bookings & Orders (booking lifecycle)
- Escrow & Payments (wallet, escrow, release, disputes)
- Loyalty & Referrals (PearlPoints, referral rewards)
- Messaging & Notifications (chat, push, email)
- Subscriptions & Monetization (premium tiers, featured listings)
- Analytics & Insights (operational and business metrics)

## Data Model Strategy

- UUID primary keys for all external entities
- PostgreSQL JSONB for flexible vertical-specific fields
- Strong foreign keys + soft deletes where required by compliance
- Outbox pattern for side effects and integration events

## Security Principles

- Never trust client-owned identifiers without ownership checks
- Laravel policies for row-level access
- Signed upload URLs + antivirus queue for KYC files
- Layered rate limits by actor and route class

## Runtime & Scaling

- Octane + Swoole for request throughput
- Horizon for queue orchestration
- Reverb for real-time event streaming
- Redis for cache/session/queue hot paths

## Observability

- Sentry traces and errors
- PostHog product analytics
- Telescope and structured logs for admin diagnostics
