<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category',
        'difficulty_level',
        'max_score',
        'time_limit',
        'image_url',
        'game_data',
        'is_active',
        'plays_count',
    ];

    protected function casts(): array
    {
        return [
            'game_data' => 'array',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the game's scores.
     */
    public function scores()
    {
        return $this->hasMany(GameScore::class);
    }

    /**
     * Get the game's leaderboard.
     */
    public function leaderboard($limit = 10)
    {
        return $this->scores()
                    ->with('user:id,name,username,avatar_url')
                    ->orderBy('score', 'desc')
                    ->orderBy('time_taken', 'asc')
                    ->limit($limit)
                    ->get();
    }

    /**
     * Get the highest score for this game.
     */
    public function getHighestScore()
    {
        return $this->scores()->max('score') ?? 0;
    }

    /**
     * Increment the play count.
     */
    public function incrementPlays()
    {
        $this->increment('plays_count');
    }

    /**
     * Scope for active games.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for games by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
