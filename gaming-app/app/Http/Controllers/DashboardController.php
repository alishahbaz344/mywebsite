<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameScore;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get user's recent games
        $recentGames = GameScore::with('game')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get user's top scores
        $topScores = GameScore::with('game')
            ->where('user_id', $user->id)
            ->orderBy('score', 'desc')
            ->limit(5)
            ->get();

        // Get user's recent achievements
        $recentAchievements = $user->achievements()
            ->orderBy('user_achievements.unlocked_at', 'desc')
            ->limit(5)
            ->get();

        // Get gaming statistics
        $totalGames = Game::active()->count();
        $gamesPlayed = GameScore::where('user_id', $user->id)
            ->distinct('game_id')
            ->count();
        
        $averageScore = GameScore::where('user_id', $user->id)
            ->avg('score') ?? 0;

        // Get completion percentage
        $completionPercentage = $totalGames > 0 ? 
            round(($gamesPlayed / $totalGames) * 100, 1) : 0;

        // Get rank statistics
        $globalRank = $this->getUserGlobalRank($user);

        return view('dashboard', compact(
            'user',
            'recentGames',
            'topScores',
            'recentAchievements',
            'totalGames',
            'gamesPlayed',
            'averageScore',
            'completionPercentage',
            'globalRank'
        ));
    }

    /**
     * Get user's global rank based on total score.
     */
    private function getUserGlobalRank($user)
    {
        return \App\Models\User::where('total_score', '>', $user->total_score)
            ->count() + 1;
    }

    /**
     * Show user profile.
     */
    public function profile()
    {
        $user = Auth::user();
        
        // Get all user's achievements grouped by rarity
        $achievements = $user->achievements()
            ->get()
            ->groupBy('rarity');

        // Get user's best scores for each game
        $bestScores = GameScore::select('game_id', \DB::raw('MAX(score) as best_score'))
            ->where('user_id', $user->id)
            ->with('game')
            ->groupBy('game_id')
            ->get();

        // Get gaming activity over time (last 30 days)
        $activity = GameScore::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as games_played, SUM(score) as total_score')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('profile', compact('user', 'achievements', 'bestScores', 'activity'));
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'avatar_url' => 'nullable|url',
            'favorite_game_category' => 'nullable|string',
            'profile_public' => 'boolean',
            'gaming_preferences' => 'nullable|array',
        ]);

        $user->update($request->only([
            'name',
            'username',
            'avatar_url',
            'favorite_game_category',
            'profile_public',
            'gaming_preferences',
        ]));

        return redirect()->route('profile')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Show leaderboard page.
     */
    public function leaderboard(Request $request)
    {
        $type = $request->get('type', 'total_score');
        
        $query = \App\Models\User::where('profile_public', true);
        
        switch ($type) {
            case 'total_score':
                $query->orderBy('total_score', 'desc');
                break;
            case 'achievement_points':
                $query->orderBy('achievement_points', 'desc');
                break;
            case 'games_played':
                $query->orderBy('games_played', 'desc');
                break;
            default:
                $query->orderBy('total_score', 'desc');
        }
        
        $users = $query->limit(50)->get();
        
        return view('leaderboard', compact('users', 'type'));
    }
}
