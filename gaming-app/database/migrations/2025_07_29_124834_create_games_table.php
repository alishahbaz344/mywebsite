<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('category');
            $table->string('difficulty_level')->default('easy');
            $table->integer('max_score')->nullable();
            $table->integer('time_limit')->nullable(); // in seconds
            $table->string('image_url')->nullable();
            $table->json('game_data')->nullable(); // for storing game-specific configuration
            $table->boolean('is_active')->default(true);
            $table->integer('plays_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
