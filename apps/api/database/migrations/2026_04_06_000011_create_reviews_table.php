<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('reviewer_user_id')->index();
            $table->uuid('provider_user_id')->index();
            $table->uuid('booking_id')->nullable()->index();
            $table->decimal('rating', 2, 1);
            $table->string('title', 180);
            $table->text('body');
            $table->boolean('is_verified')->default(false);
            $table->jsonb('metadata')->nullable();
            $table->timestamps();

            $table->foreign('reviewer_user_id')->references('id')->on('users');
            $table->foreign('provider_user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};