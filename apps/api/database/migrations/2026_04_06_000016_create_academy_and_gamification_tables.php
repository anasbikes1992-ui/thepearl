<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('academy_courses', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('audience', 40)->default('provider');
            $table->boolean('is_published')->default(false);
            $table->jsonb('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('academy_course_lessons', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('course_id')->index();
            $table->string('title');
            $table->unsignedInteger('position');
            $table->string('video_url')->nullable();
            $table->longText('content')->nullable();
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('academy_courses');
        });

        Schema::create('academy_user_course_progress', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index();
            $table->uuid('course_id')->index();
            $table->decimal('completion_percent', 5, 2)->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'course_id']);
        });

        Schema::create('gamification_badges', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('points_reward')->default(0);
            $table->jsonb('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('gamification_user_badges', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index();
            $table->uuid('badge_id')->index();
            $table->timestamp('awarded_at')->nullable();
            $table->timestamps();

            $table->foreign('badge_id')->references('id')->on('gamification_badges');
            $table->unique(['user_id', 'badge_id']);
         });
     }
 
     public function down(): void
     {
        Schema::dropIfExists('gamification_user_badges');
        Schema::dropIfExists('gamification_badges');
        Schema::dropIfExists('academy_user_course_progress');
         Schema::dropIfExists('academy_course_lessons');
         Schema::dropIfExists('academy_courses');
     }
 };
