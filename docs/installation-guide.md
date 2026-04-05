# Full Installation and Run Guide

This guide sets up the PearlHub monorepo locally for web, API, and supporting services.

## 1. Prerequisites

Install the following:

- Node.js 22+
- pnpm 10+
- PHP 8.3+
- Composer 2.8+
- PostgreSQL 17+
- Redis 7+
- Flutter 3.24+ (for mobile apps)

Optional for local containerized infrastructure:

- Docker Desktop + Docker Compose

## 2. Clone and Bootstrap

```bash
git clone <your-repo-url> "THE PEARL"
cd "THE PEARL"
pnpm install
```

## 3. Environment Setup

At repo root:

```bash
cp .env.example .env
```

API app environment:

```bash
cd apps/api
cp .env.example .env
php artisan key:generate
```

Populate DB/Redis and any provider keys in `apps/api/.env`.

## 4. Start Infrastructure

From repository root:

```bash
pnpm dev:stack
```

If not using containerized services, ensure PostgreSQL and Redis are running and reachable by API `.env` settings.

## 5. API Setup and Run

```bash
cd apps/api
composer install
php artisan migrate --seed
php artisan serve
```

API default local URL:
- `http://127.0.0.1:8000`

## 6. Web Setup and Run

```bash
cd apps/web
pnpm dev
```

## 7. Mobile Setup (Optional)

```bash
cd apps/mobile
flutter pub get
flutter run
```

## 8. Verification Commands

API tests:

```bash
cd apps/api
php artisan test
```

Root quality checks (if configured):

```bash
cd "THE PEARL"
pnpm lint
pnpm test
```

## 9. Enhancement Endpoints Smoke Test

Once authenticated token is available:

- `POST /api/v1/pricing/estimate`
- `POST /api/v1/escrow/{escrow}/signals`
- `POST /api/v1/bundles/compose`
- `POST /api/v1/concierge/convert`
- `GET /api/v1/trust/score/{user}`
- `GET /api/v1/providers/os/dashboard`
- `GET /api/v1/market-playbooks?city=Colombo&vertical=stays`

## 10. Troubleshooting

1. Composer dependency errors
- Run `composer clear-cache` then `composer install`.

2. App key missing
- Run `php artisan key:generate`.

3. Database connection failures
- Validate `DB_*` values in `apps/api/.env` and ensure Postgres is up.

4. Redis/queue issues
- Validate `REDIS_*` values and run Redis locally.

5. PHP deprecation warnings in test output
- Current warnings are dependency-level (`PDO::MYSQL_ATTR_SSL_CA`) and do not block feature behavior.

## 11. Production Notes

- Run migrations with force flag:

```bash
php artisan migrate --force
```

- Ensure queue workers and scheduler are configured.
- Ensure secure secret management for all provider/API keys.
- Keep webhook idempotency tables enabled and monitored.
