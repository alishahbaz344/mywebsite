<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /**
     * Display a listing of games.
     */
    public function index(Request $request)
    {
        $query = Game::active();

        // Filter by category if provided
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $games = $query->orderBy('plays_count', 'desc')
                      ->paginate(12);

        $categories = Game::active()
                         ->distinct()
                         ->pluck('category')
                         ->sort();

        return view('games.index', compact('games', 'categories'));
    }

    /**
     * Display the specified game.
     */
    public function show(Game $game)
    {
        if (!$game->is_active) {
            abort(404);
        }

        $leaderboard = $game->leaderboard(10);
        $userBestScore = null;
        $userRank = null;

        if (Auth::check()) {
            $userBestScore = Auth::user()->getHighScore($game->id);
            $userRank = Auth::user()->getRank($game->id);
        }

        return view('games.show', compact('game', 'leaderboard', 'userBestScore', 'userRank'));
    }

    /**
     * Start playing a game.
     */
    public function play(Game $game)
    {
        if (!$game->is_active) {
            abort(404);
        }

        // Increment play count
        $game->incrementPlays();

        // Update user's last played timestamp
        if (Auth::check()) {
            Auth::user()->update(['last_played_at' => now()]);
        }

        return view('games.play', compact('game'));
    }

    /**
     * Get game data for AJAX requests.
     */
    public function gameData(Game $game)
    {
        if (!$game->is_active) {
            abort(404);
        }

        return response()->json([
            'id' => $game->id,
            'name' => $game->name,
            'category' => $game->category,
            'difficulty_level' => $game->difficulty_level,
            'max_score' => $game->max_score,
            'time_limit' => $game->time_limit,
            'game_data' => $game->game_data,
        ]);
    }

    /**
     * Submit a game score.
     */
    public function submitScore(Request $request, Game $game)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Authentication required'], 401);
        }

        $request->validate([
            'score' => 'required|integer|min:0',
            'time_taken' => 'nullable|integer|min:0',
            'level_reached' => 'nullable|integer|min:0',
            'game_data' => 'nullable|array',
        ]);

        // Check if score is within reasonable bounds
        if ($game->max_score && $request->score > $game->max_score) {
            return response()->json(['error' => 'Invalid score'], 400);
        }

        // Create game score record
        $gameScore = GameScore::create([
            'user_id' => Auth::id(),
            'game_id' => $game->id,
            'score' => $request->score,
            'time_taken' => $request->time_taken,
            'level_reached' => $request->level_reached,
            'game_data' => $request->game_data,
        ]);

        // Update user statistics
        $user = Auth::user();
        $user->increment('games_played');
        $user->increment('total_score', $request->score);

        // Check for new personal best
        $personalBest = $user->getHighScore($game->id);
        $isNewBest = $request->score >= $personalBest;

        // Get updated rank
        $newRank = $user->getRank($game->id);

        return response()->json([
            'success' => true,
            'score' => $request->score,
            'personal_best' => $personalBest,
            'is_new_best' => $isNewBest,
            'rank' => $newRank,
            'leaderboard' => $game->leaderboard(10),
        ]);
    }

    /**
     * Get games by category.
     */
    public function byCategory($category)
    {
        $games = Game::active()
                    ->byCategory($category)
                    ->orderBy('plays_count', 'desc')
                    ->paginate(12);

        return view('games.category', compact('games', 'category'));
    }
}
