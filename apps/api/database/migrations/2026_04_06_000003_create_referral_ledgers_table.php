<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('referral_ledgers', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('referrer_user_id')->index();
            $table->uuid('referred_user_id')->index();
            $table->uuid('trigger_transaction_id')->nullable()->index();
            $table->unsignedInteger('points_awarded_referrer')->default(0);
            $table->unsignedInteger('points_awarded_referred')->default(0);
            $table->string('status')->default('pending');
            $table->jsonb('metadata')->nullable();
            $table->timestamps();

            $table->foreign('referrer_user_id')->references('id')->on('users');
            $table->foreign('referred_user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referral_ledgers');
    }
};
