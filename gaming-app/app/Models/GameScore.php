<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GameScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_id',
        'score',
        'time_taken',
        'level_reached',
        'game_data',
    ];

    protected function casts(): array
    {
        return [
            'game_data' => 'array',
        ];
    }

    /**
     * Get the user that owns the score.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the game that this score belongs to.
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Scope for getting personal best scores.
     */
    public function scopePersonalBest($query, $userId, $gameId)
    {
        return $query->where('user_id', $userId)
                    ->where('game_id', $gameId)
                    ->orderBy('score', 'desc')
                    ->first();
    }

    /**
     * Scope for getting top scores.
     */
    public function scopeTopScores($query, $gameId, $limit = 10)
    {
        return $query->where('game_id', $gameId)
                    ->orderBy('score', 'desc')
                    ->orderBy('time_taken', 'asc')
                    ->limit($limit);
    }
}
