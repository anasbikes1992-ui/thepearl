# Deployment Guide

## Web (Vercel)

1. Import repository into Vercel.
2. Set project root to `apps/web`.
3. Build command: `pnpm build`.
4. Install command: `pnpm install`.
5. Output directory: `.next`.
6. Set environment variables from `apps/web/.env.example`.
7. Enable Preview Deployments for all PRs.

## API (Coolify / Forge / Railway)

1. Deploy from `apps/api` using PHP 8.3 runtime.
2. Configure Octane with Swoole as process manager.
3. Run migration command on release: `php artisan migrate --force`.
4. Queue workers: Horizon with auto-scaling pools.
5. Configure Redis and Postgres external services.
6. Add worker for `queue:work` and scheduler for `schedule:run`.

## DB/Cache

- PostgreSQL 17 on Neon or Railway managed cluster.
- Redis 7 for cache/session/queue.

## CI/CD

- GitHub Actions executes lint, typecheck, and tests.
- Protected main branch with required checks.
- Tag-based release flow for API and web.
