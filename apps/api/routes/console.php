<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('pearlhub:about', function (): void {
    $this->comment('PearlHub API runtime is bootstrapped.');
});