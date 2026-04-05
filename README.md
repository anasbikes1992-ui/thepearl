# PearlHub 2.0

Sri Lanka-first luxury multi-vertical marketplace platform.

## Tech Stack

- Monorepo: Turborepo + pnpm workspaces
- Web: Next.js App Router + TypeScript + Tailwind v4
- API: Laravel 11 modular monolith (Octane-ready)
- Mobile: Flutter apps (customer, provider, admin)
- Data: PostgreSQL 17 + Redis 7 + Meilisearch

## Verticals

- Property
- Stays
- Vehicles
- Events
- SME Food & Services
- Tours & Experiences
- Home & Beauty Services

## Quick Start

1. Install Node 22+, pnpm 10+, PHP 8.3+, Composer 2.8+, Flutter 3.24+
2. Copy `.env.example` to `.env`
3. Install root dependencies: `pnpm install`
4. Start data services: `pnpm dev:stack`
5. Web app setup: see `apps/web/README.md`
6. API setup: see `apps/api/README.md`
7. Mobile setup: see `apps/mobile/README.md`

## Delivery Status

- Phases 1-5 implementation scaffolding: completed
- Detailed roadmap: `docs/implementation-plan.md`
- Concrete deliverables: `docs/phase-deliverables.md`
