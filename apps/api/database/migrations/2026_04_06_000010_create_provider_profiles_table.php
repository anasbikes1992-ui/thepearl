<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('provider_profiles', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->unique();
            $table->string('business_name');
            $table->jsonb('verticals');
            $table->text('bio')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('website_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('supports_livestream')->default(false);
            $table->boolean('supports_resale')->default(false);
            $table->decimal('sustainability_score', 5, 2)->default(0);
            $table->jsonb('metadata')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provider_profiles');
    }
};