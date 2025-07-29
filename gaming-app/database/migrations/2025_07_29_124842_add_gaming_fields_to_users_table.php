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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable();
            $table->string('avatar_url')->nullable();
            $table->integer('total_score')->default(0);
            $table->integer('achievement_points')->default(0);
            $table->integer('games_played')->default(0);
            $table->string('favorite_game_category')->nullable();
            $table->timestamp('last_played_at')->nullable();
            $table->json('gaming_preferences')->nullable();
            $table->boolean('profile_public')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'avatar_url',
                'total_score',
                'achievement_points',
                'games_played',
                'favorite_game_category',
                'last_played_at',
                'gaming_preferences',
                'profile_public'
            ]);
        });
    }
};
