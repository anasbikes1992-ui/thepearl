<?php

use App\Services\EscrowCalculator;

it('calculates escrow breakdown', function (): void {
    $service = new EscrowCalculator();

    $result = $service->breakdown(10000.0, 0.10, 0.015);

    expect($result['commission_amount'])->toBe(1000.0)
        ->and($result['escrow_fee_amount'])->toBe(150.0)
        ->and($result['provider_net_amount'])->toBe(8850.0);
});
