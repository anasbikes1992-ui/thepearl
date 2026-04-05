<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('provider_id')->index();
            $table->string('vertical', 64)->index();
            $table->string('title', 180);
            $table->string('slug', 220)->unique();
            $table->text('description');
            $table->decimal('base_price', 12, 2);
            $table->string('currency', 3)->default('LKR');
            $table->string('district', 120)->index();
            $table->string('city', 120)->index();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('status', 32)->default('draft')->index();
            $table->boolean('is_featured')->default(false);
            $table->jsonb('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('provider_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
