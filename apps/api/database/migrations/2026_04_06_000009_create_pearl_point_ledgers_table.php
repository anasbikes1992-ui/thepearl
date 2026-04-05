<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pearl_point_ledgers', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index();
            $table->integer('points_delta');
            $table->string('reason', 120);
            $table->jsonb('metadata')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pearl_point_ledgers');
    }
};
