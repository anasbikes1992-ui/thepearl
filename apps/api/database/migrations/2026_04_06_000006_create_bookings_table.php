<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('listing_id')->index();
            $table->uuid('customer_id')->index();
            $table->uuid('provider_id')->index();
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('subtotal', 12, 2);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2);
            $table->string('currency', 3)->default('LKR');
            $table->string('status', 32)->default('pending')->index();
            $table->jsonb('metadata')->nullable();
            $table->timestamps();

            $table->foreign('listing_id')->references('id')->on('listings');
            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('provider_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
