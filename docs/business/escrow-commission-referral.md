# Business Logic Flows

## Escrow Flow

1. Customer creates booking/order and confirms payment intent.
2. Payment gateway capture moves funds into platform-held escrow wallet.
3. Escrow status transitions to `held`.
4. Provider completes service; proof-of-completion event emitted.
5. If no dispute in SLA window, auto-release executes.
6. Commission and escrow fee are deducted, provider payout marked `pending_settlement`.
7. Settlement job transfers payout to provider account and marks ledger entries finalized.

## Commission Calculation

- Base commission by vertical: 8% to 15%
- Premium providers may receive reduced commission based on tier
- Formula:
  - `gross = subtotal + addons - discounts`
  - `commission = gross * commission_rate`
  - `escrow_fee = gross * escrow_fee_rate`
  - `provider_net = gross - commission - escrow_fee`

## Referral + PearlPoints

- New customer signs up with referral code.
- On first eligible completed transaction:
  - referrer gets PearlPoints bonus
  - referred user gets welcome points
- Anti-abuse constraints:
  - one referral reward per unique KYC identity
  - velocity checks per device and payout method
  - manual review queue for suspicious clusters

## Dispute Path

- Either party can open dispute before auto-release deadline.
- Escrow state becomes `in_dispute` and release timer halts.
- Admin mediator decision produces split payout or refund.
- Immutable audit trail stored for compliance.
