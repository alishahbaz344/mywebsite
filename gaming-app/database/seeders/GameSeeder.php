<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = [
            [
                'name' => 'Number Guessing Game',
                'slug' => 'number-guessing',
                'description' => 'Guess the random number between 1 and 100. Fewer guesses means higher score!',
                'category' => 'puzzle',
                'difficulty_level' => 'easy',
                'max_score' => 1000,
                'time_limit' => 300, // 5 minutes
                'game_data' => [
                    'min_number' => 1,
                    'max_number' => 100,
                    'max_guesses' => 10
                ],
            ],
            [
                'name' => 'Snake Game',
                'slug' => 'snake',
                'description' => 'Classic snake game! Eat food to grow longer and avoid hitting walls or yourself.',
                'category' => 'arcade',
                'difficulty_level' => 'medium',
                'max_score' => null,
                'time_limit' => null,
                'game_data' => [
                    'grid_size' => 20,
                    'initial_speed' => 200
                ],
            ],
            [
                'name' => 'Memory Match',
                'slug' => 'memory-match',
                'description' => 'Flip cards to find matching pairs. Complete the game as fast as possible!',
                'category' => 'puzzle',
                'difficulty_level' => 'easy',
                'max_score' => 5000,
                'time_limit' => 180, // 3 minutes
                'game_data' => [
                    'grid_rows' => 4,
                    'grid_cols' => 4,
                    'card_types' => 8
                ],
            ],
            [
                'name' => 'Tetris Clone',
                'slug' => 'tetris',
                'description' => 'Classic block-stacking puzzle game. Clear lines by filling rows completely.',
                'category' => 'puzzle',
                'difficulty_level' => 'hard',
                'max_score' => null,
                'time_limit' => null,
                'game_data' => [
                    'board_width' => 10,
                    'board_height' => 20,
                    'level_speed_increase' => 50
                ],
            ],
            [
                'name' => 'Flappy Bird Clone',
                'slug' => 'flappy-bird',
                'description' => 'Navigate through pipes by clicking to flap. How far can you go?',
                'category' => 'arcade',
                'difficulty_level' => 'medium',
                'max_score' => null,
                'time_limit' => null,
                'game_data' => [
                    'pipe_gap' => 150,
                    'pipe_speed' => 2,
                    'gravity' => 0.5
                ],
            ],
            [
                'name' => 'Math Quiz',
                'slug' => 'math-quiz',
                'description' => 'Solve math problems as quickly as possible. Difficulty increases with each level!',
                'category' => 'educational',
                'difficulty_level' => 'easy',
                'max_score' => 10000,
                'time_limit' => 600, // 10 minutes
                'game_data' => [
                    'questions_per_level' => 5,
                    'time_per_question' => 30,
                    'max_level' => 10
                ],
            ],
            [
                'name' => 'Rock Paper Scissors',
                'slug' => 'rock-paper-scissors',
                'description' => 'Classic game against the computer. Best of 10 rounds wins!',
                'category' => 'strategy',
                'difficulty_level' => 'easy',
                'max_score' => 100,
                'time_limit' => 300, // 5 minutes
                'game_data' => [
                    'rounds_to_win' => 6,
                    'total_rounds' => 10
                ],
            ],
            [
                'name' => 'Tic Tac Toe',
                'slug' => 'tic-tac-toe',
                'description' => 'Classic 3x3 grid game. Get three in a row to win against the AI!',
                'category' => 'strategy',
                'difficulty_level' => 'easy',
                'max_score' => 50,
                'time_limit' => 180, // 3 minutes
                'game_data' => [
                    'grid_size' => 3,
                    'ai_difficulty' => 'medium'
                ],
            ],
            [
                'name' => 'Word Scramble',
                'slug' => 'word-scramble',
                'description' => 'Unscramble letters to form words. Longer words give more points!',
                'category' => 'educational',
                'difficulty_level' => 'medium',
                'max_score' => 5000,
                'time_limit' => 300, // 5 minutes
                'game_data' => [
                    'min_word_length' => 4,
                    'max_word_length' => 8,
                    'words_per_game' => 15
                ],
            ],
            [
                'name' => 'Simon Says',
                'slug' => 'simon-says',
                'description' => 'Remember and repeat the sequence of colors. How long can you go?',
                'category' => 'puzzle',
                'difficulty_level' => 'medium',
                'max_score' => null,
                'time_limit' => null,
                'game_data' => [
                    'colors' => ['red', 'blue', 'green', 'yellow'],
                    'sequence_speed' => 1000
                ],
            ]
        ];

        foreach ($games as $gameData) {
            Game::create($gameData);
        }
    }
}
