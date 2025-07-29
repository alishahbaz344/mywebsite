<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    /**
     * Display a listing of achievements.
     */
    public function index(Request $request)
    {
        $query = Achievement::active();

        // Filter by type if provided
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        // Filter by rarity if provided
        if ($request->filled('rarity')) {
            $query->byRarity($request->rarity);
        }

        $achievements = $query->orderBy('rarity')
                            ->orderBy('points', 'desc')
                            ->paginate(20);

        // Get user's unlocked achievements if authenticated
        $userAchievements = [];
        if (Auth::check()) {
            $userAchievements = Auth::user()->achievements()
                                        ->pluck('achievements.id')
                                        ->toArray();
        }

        // Get filter options
        $types = Achievement::active()
                           ->distinct()
                           ->pluck('type')
                           ->sort();

        $rarities = ['common', 'rare', 'epic', 'legendary'];

        return view('achievements.index', compact(
            'achievements',
            'userAchievements',
            'types',
            'rarities'
        ));
    }

    /**
     * Display the specified achievement.
     */
    public function show(Achievement $achievement)
    {
        if (!$achievement->is_active) {
            abort(404);
        }

        // Check if user has unlocked this achievement
        $isUnlocked = false;
        $unlockedAt = null;
        if (Auth::check()) {
            $userAchievement = Auth::user()->achievements()
                                         ->where('achievements.id', $achievement->id)
                                         ->first();
            if ($userAchievement) {
                $isUnlocked = true;
                $unlockedAt = $userAchievement->pivot->unlocked_at;
            }
        }

        // Get unlock statistics
        $unlockPercentage = $achievement->getUnlockPercentage();
        $totalUnlocks = $achievement->users()->count();

        // Get recent unlocks
        $recentUnlocks = $achievement->users()
                                   ->orderBy('user_achievements.unlocked_at', 'desc')
                                   ->limit(10)
                                   ->get();

        return view('achievements.show', compact(
            'achievement',
            'isUnlocked',
            'unlockedAt',
            'unlockPercentage',
            'totalUnlocks',
            'recentUnlocks'
        ));
    }
}
