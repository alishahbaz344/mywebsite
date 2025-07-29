<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            // Score-based achievements
            [
                'name' => 'First Score',
                'slug' => 'first-score',
                'description' => 'Submit your first game score!',
                'icon' => '🎯',
                'type' => 'score_based',
                'requirements' => ['min_score' => 1],
                'points' => 10,
                'rarity' => 'common',
            ],
            [
                'name' => 'Century Club',
                'slug' => 'century-club',
                'description' => 'Score 100 points in any game.',
                'icon' => '💯',
                'type' => 'score_based',
                'requirements' => ['min_score' => 100],
                'points' => 25,
                'rarity' => 'common',
            ],
            [
                'name' => 'High Roller',
                'slug' => 'high-roller',
                'description' => 'Score 1000 points in any game.',
                'icon' => '🚀',
                'type' => 'score_based',
                'requirements' => ['min_score' => 1000],
                'points' => 100,
                'rarity' => 'rare',
            ],
            [
                'name' => 'Score Master',
                'slug' => 'score-master',
                'description' => 'Score 5000 points in any game.',
                'icon' => '👑',
                'type' => 'score_based',
                'requirements' => ['min_score' => 5000],
                'points' => 250,
                'rarity' => 'epic',
            ],
            [
                'name' => 'Legendary Scorer',
                'slug' => 'legendary-scorer',
                'description' => 'Score 10000 points in any game.',
                'icon' => '⭐',
                'type' => 'score_based',
                'requirements' => ['min_score' => 10000],
                'points' => 500,
                'rarity' => 'legendary',
            ],

            // Play count achievements
            [
                'name' => 'Getting Started',
                'slug' => 'getting-started',
                'description' => 'Play your first game!',
                'icon' => '🎮',
                'type' => 'play_count',
                'requirements' => ['games_played' => 1],
                'points' => 5,
                'rarity' => 'common',
            ],
            [
                'name' => 'Game Explorer',
                'slug' => 'game-explorer',
                'description' => 'Play 10 different games.',
                'icon' => '🗺️',
                'type' => 'play_count',
                'requirements' => ['unique_games_played' => 10],
                'points' => 50,
                'rarity' => 'common',
            ],
            [
                'name' => 'Dedicated Gamer',
                'slug' => 'dedicated-gamer',
                'description' => 'Play 50 games total.',
                'icon' => '🎯',
                'type' => 'play_count',
                'requirements' => ['total_games_played' => 50],
                'points' => 75,
                'rarity' => 'rare',
            ],
            [
                'name' => 'Gaming Addict',
                'slug' => 'gaming-addict',
                'description' => 'Play 100 games total.',
                'icon' => '🔥',
                'type' => 'play_count',
                'requirements' => ['total_games_played' => 100],
                'points' => 150,
                'rarity' => 'epic',
            ],

            // Time-based achievements
            [
                'name' => 'Speed Demon',
                'slug' => 'speed-demon',
                'description' => 'Complete a game in under 30 seconds.',
                'icon' => '⚡',
                'type' => 'time_based',
                'requirements' => ['max_time' => 30],
                'points' => 50,
                'rarity' => 'rare',
            ],
            [
                'name' => 'Marathon Runner',
                'slug' => 'marathon-runner',
                'description' => 'Play for over 30 minutes in a single session.',
                'icon' => '🏃',
                'type' => 'time_based',
                'requirements' => ['session_time' => 1800], // 30 minutes
                'points' => 100,
                'rarity' => 'epic',
            ],

            // Category-specific achievements
            [
                'name' => 'Puzzle Master',
                'slug' => 'puzzle-master',
                'description' => 'Complete 10 puzzle games.',
                'icon' => '🧩',
                'type' => 'category_based',
                'requirements' => ['category' => 'puzzle', 'games_completed' => 10],
                'points' => 75,
                'rarity' => 'rare',
            ],
            [
                'name' => 'Arcade Legend',
                'slug' => 'arcade-legend',
                'description' => 'Complete 10 arcade games.',
                'icon' => '🕹️',
                'type' => 'category_based',
                'requirements' => ['category' => 'arcade', 'games_completed' => 10],
                'points' => 75,
                'rarity' => 'rare',
            ],
            [
                'name' => 'Strategic Mind',
                'slug' => 'strategic-mind',
                'description' => 'Complete 10 strategy games.',
                'icon' => '♟️',
                'type' => 'category_based',
                'requirements' => ['category' => 'strategy', 'games_completed' => 10],
                'points' => 75,
                'rarity' => 'rare',
            ],
            [
                'name' => 'Scholar',
                'slug' => 'scholar',
                'description' => 'Complete 10 educational games.',
                'icon' => '📚',
                'type' => 'category_based',
                'requirements' => ['category' => 'educational', 'games_completed' => 10],
                'points' => 75,
                'rarity' => 'rare',
            ],

            // Special achievements
            [
                'name' => 'Perfect Score',
                'slug' => 'perfect-score',
                'description' => 'Achieve the maximum possible score in a game.',
                'icon' => '💎',
                'type' => 'special',
                'requirements' => ['perfect_score' => true],
                'points' => 200,
                'rarity' => 'epic',
            ],
            [
                'name' => 'Comeback Kid',
                'slug' => 'comeback-kid',
                'description' => 'Improve your personal best by 50% or more.',
                'icon' => '📈',
                'type' => 'special',
                'requirements' => ['improvement_percentage' => 50],
                'points' => 100,
                'rarity' => 'rare',
            ],
            [
                'name' => 'Consistent Player',
                'slug' => 'consistent-player',
                'description' => 'Play games for 7 consecutive days.',
                'icon' => '📅',
                'type' => 'streak',
                'requirements' => ['consecutive_days' => 7],
                'points' => 150,
                'rarity' => 'epic',
            ],
            [
                'name' => 'Ultimate Champion',
                'slug' => 'ultimate-champion',
                'description' => 'Reach #1 on any game leaderboard.',
                'icon' => '🏆',
                'type' => 'leaderboard',
                'requirements' => ['leaderboard_position' => 1],
                'points' => 500,
                'rarity' => 'legendary',
            ],
        ];

        foreach ($achievements as $achievementData) {
            Achievement::create($achievementData);
        }
    }
}
