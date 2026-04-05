<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kyc_verification_events', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index();
            $table->uuid('actor_user_id')->nullable()->index();
            $table->string('provider', 80);
            $table->string('event_type', 80);
            $table->string('status', 40)->index();
            $table->text('notes')->nullable();
            $table->jsonb('payload')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kyc_verification_events');
    }
};