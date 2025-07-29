<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'type',
        'requirements',
        'points',
        'rarity',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'requirements' => 'array',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the users who have unlocked this achievement.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_achievements')
                    ->withPivot('unlocked_at', 'unlock_data')
                    ->withTimestamps();
    }

    /**
     * Check if a user has unlocked this achievement.
     */
    public function isUnlockedBy($userId)
    {
        return $this->users()->where('user_id', $userId)->exists();
    }

    /**
     * Get the unlock percentage for this achievement.
     */
    public function getUnlockPercentage()
    {
        $totalUsers = User::count();
        $unlockedUsers = $this->users()->count();
        
        return $totalUsers > 0 ? round(($unlockedUsers / $totalUsers) * 100, 2) : 0;
    }

    /**
     * Scope for active achievements.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for achievements by type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for achievements by rarity.
     */
    public function scopeByRarity($query, $rarity)
    {
        return $query->where('rarity', $rarity);
    }
}
