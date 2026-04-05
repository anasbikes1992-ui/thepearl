<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('disputes', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('booking_id')->index();
            $table->uuid('escrow_transaction_id')->index();
            $table->uuid('opened_by_user_id')->index();
            $table->string('status', 32)->default('open')->index();
            $table->text('reason');
            $table->jsonb('resolution')->nullable();
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings');
            $table->foreign('escrow_transaction_id')->references('id')->on('escrow_transactions');
            $table->foreign('opened_by_user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disputes');
    }
};
