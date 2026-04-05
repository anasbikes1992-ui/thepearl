<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('escrow_transactions', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('booking_id')->index();
            $table->uuid('customer_id')->index();
            $table->uuid('provider_id')->index();
            $table->decimal('gross_amount', 12, 2);
            $table->decimal('commission_rate', 6, 4)->default(0.1000);
            $table->decimal('escrow_fee_rate', 6, 4)->default(0.0150);
            $table->decimal('commission_amount', 12, 2);
            $table->decimal('escrow_fee_amount', 12, 2);
            $table->decimal('provider_net_amount', 12, 2);
            $table->string('currency', 3)->default('LKR');
            $table->string('status')->default('held');
            $table->timestamp('auto_release_at')->nullable()->index();
            $table->timestamp('released_at')->nullable();
            $table->jsonb('metadata')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('provider_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('escrow_transactions');
    }
};
