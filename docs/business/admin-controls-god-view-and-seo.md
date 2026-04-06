# Admin Controls, God View, Referral Revenue, and SEO Upgrades

## Why this upgrade

This phase improves platform governance and monetization with:

- stronger admin controls for pricing and referral economics
- better executive visibility into incoming revenue
- referral bonus automation to increase acquisition loops
- improved SEO indexability and metadata hygiene

## Backend additions

### Admin control plane

Added endpoints (admin/super-admin only):

- `GET /api/v1/admin/controls`
- `PUT /api/v1/admin/controls`

Control model includes:

- per-vertical commission overrides
- referral bonus points for referrer/referred users
- referral multiplier for promo windows
- guardrails for min/max commission and points

Implementation files:

- `apps/api/config/business_controls.php`
- `apps/api/app/Services/Admin/BusinessControlService.php`
- `apps/api/app/Http/Controllers/Api/V1/Admin/AdminControlController.php`

### Global God View

Added endpoint (admin/super-admin only):

- `GET /api/v1/admin/god-view`

Included metrics:

- take today, take 30d, GMV 30d
- forecast take next 30d
- subscription MRR
- referral issuance summary
- open dispute and held escrow risk signals
- growth metrics and top vertical take

Implementation files:

- `apps/api/app/Services/Analytics/GodViewService.php`
- `apps/api/app/Http/Controllers/Api/V1/Admin/AdminControlController.php`

### Revenue logic improvements

- Commission strategy is now runtime-tunable via admin controls.
- Referral bonus points are now dynamic and admin-controlled.
- Booking completion triggers first-transaction referral rewards when eligible.
- Loyalty now exposes referral earnings history and totals.

Revenue logic files:

- `apps/api/app/Services/Finance/CommissionService.php`
- `apps/api/app/Services/Loyalty/ReferralService.php`
- `apps/api/app/Http/Controllers/Api/V1/Bookings/BookingController.php`
- `apps/api/app/Http/Controllers/Api/V1/LoyaltyController.php`

New loyalty endpoint:

- `GET /api/v1/loyalty/referrals`

## SEO upgrades (web)

- Global metadata now includes canonical, metadataBase, keywords, OpenGraph URL, and Twitter card metadata.
- Sitemap now includes broader marketplace coverage with `lastModified` and tuned priorities.
- A robots route was added with sitemap and crawl rules.

SEO files:

- `apps/web/src/app/layout.tsx`
- `apps/web/src/app/sitemap.ts`
- `apps/web/src/app/robots.ts`

## Operational notes

- Admin controls are cache-backed (`business_controls.overrides`) for immediate effect.
- Defaults remain available in `config/business_controls.php`.
- A future phase can persist immutable audit records for every control change.

## Security and access

- Admin endpoints enforce role checks for `admin` and `super-admin`.
- Existing API throttle protections remain active.
- Referral awarding includes anti-self-referral and first-completed-booking gating.

## Recommended next steps

- Add immutable audit logs for each admin control update.
- Add A/B experiment tags for referral multipliers.
- Connect God View to an admin web dashboard with visual analytics.
