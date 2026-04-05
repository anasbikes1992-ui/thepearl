<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('resale_listings', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('provider_user_id')->index();
            $table->string('vertical', 64);
            $table->string('title');
            $table->string('condition_grade', 20);
            $table->decimal('price', 12, 2);
            $table->string('currency', 3)->default('LKR');
            $table->string('status', 32)->default('draft');
            $table->jsonb('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('sustainability_badges', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('provider_user_id')->index();
            $table->string('badge_type', 80);
            $table->decimal('score', 5, 2)->default(0);
            $table->timestamp('issued_at')->nullable();
            $table->jsonb('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('platform_events', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('aggregate_type', 80)->index();
            $table->uuid('aggregate_id')->index();
            $table->string('event_name', 120)->index();
            $table->unsignedInteger('event_version')->default(1);
            $table->jsonb('payload');
            $table->timestamp('occurred_at');
            $table->timestamps();
        });

        Schema::create('tenants', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('code', 80)->unique();
            $table->string('name');
            $table->string('domain')->nullable()->unique();
            $table->string('status', 32)->default('active');
            $table->jsonb('settings')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
        Schema::dropIfExists('platform_events');
        Schema::dropIfExists('sustainability_badges');
        Schema::dropIfExists('resale_listings');
    }
};
