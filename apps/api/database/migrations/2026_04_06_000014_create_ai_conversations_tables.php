<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ai_conversations', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index();
            $table->string('channel', 20)->default('text');
            $table->string('locale', 8)->default('en');
            $table->jsonb('context')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();
        });

        Schema::create('ai_conversation_messages', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('conversation_id')->index();
            $table->string('role', 20);
            $table->text('content');
            $table->jsonb('metadata')->nullable();
            $table->timestamps();

            $table->foreign('conversation_id')->references('id')->on('ai_conversations');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_conversation_messages');
        Schema::dropIfExists('ai_conversations');
    }
};
