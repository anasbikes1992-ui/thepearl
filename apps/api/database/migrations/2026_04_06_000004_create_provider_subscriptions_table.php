<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('provider_subscriptions', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('provider_id')->index();
            $table->string('tier');
            $table->decimal('monthly_price', 10, 2);
            $table->decimal('commission_discount_rate', 6, 4)->default(0.0000);
            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();

            $table->foreign('provider_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provider_subscriptions');
    }
};
