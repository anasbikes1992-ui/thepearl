<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('social_follows', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('follower_user_id')->index();
            $table->uuid('following_user_id')->index();
            $table->timestamps();
            $table->unique(['follower_user_id', 'following_user_id']);
        });

        Schema::create('livestreams', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('provider_user_id')->index();
            $table->string('title');
            $table->string('vertical', 64);
            $table->string('status', 40)->default('scheduled');
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->string('stream_key', 180)->nullable();
            $table->unsignedInteger('viewer_count')->default(0);
            $table->jsonb('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('livestream_messages', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('livestream_id')->index();
            $table->uuid('user_id')->index();
            $table->text('message');
            $table->jsonb('metadata')->nullable();
            $table->timestamps();

            $table->foreign('livestream_id')->references('id')->on('livestreams');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livestream_messages');
        Schema::dropIfExists('livestreams');
        Schema::dropIfExists('social_follows');
    }
};
