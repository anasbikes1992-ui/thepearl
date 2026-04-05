<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('provider_payouts', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('provider_id')->index();
            $table->uuid('escrow_transaction_id')->index();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('LKR');
            $table->string('status', 32)->default('pending_settlement')->index();
            $table->timestamp('settled_at')->nullable();
            $table->timestamps();

            $table->foreign('provider_id')->references('id')->on('users');
            $table->foreign('escrow_transaction_id')->references('id')->on('escrow_transactions');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provider_payouts');
    }
};
