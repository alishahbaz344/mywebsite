<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'avatar_url',
        'total_score',
        'achievement_points',
        'games_played',
        'favorite_game_category',
        'last_played_at',
        'gaming_preferences',
        'profile_public',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_played_at' => 'datetime',
            'gaming_preferences' => 'array',
            'profile_public' => 'boolean',
        ];
    }

    /**
     * Get the user's game scores.
     */
    public function gameScores()
    {
        return $this->hasMany(GameScore::class);
    }

    /**
     * Get the user's achievements.
     */
    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements')
                    ->withPivot('unlocked_at', 'unlock_data')
                    ->withTimestamps();
    }

    /**
     * Get the user's high score for a specific game.
     */
    public function getHighScore($gameId)
    {
        return $this->gameScores()
                    ->where('game_id', $gameId)
                    ->max('score') ?? 0;
    }

    /**
     * Get the user's rank for a specific game.
     */
    public function getRank($gameId)
    {
        $userHighScore = $this->getHighScore($gameId);
        
        return GameScore::where('game_id', $gameId)
                       ->where('score', '>', $userHighScore)
                       ->distinct('user_id')
                       ->count() + 1;
    }
}
