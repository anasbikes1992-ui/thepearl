<?php

use App\Services\Finance\CommissionService;

it('returns vertical specific commission rate', function (): void {
    $service = new CommissionService();

    expect($service->rateForVertical('property'))->toBe(0.12)
        ->and($service->rateForVertical('home_beauty'))->toBe(0.08);
});
