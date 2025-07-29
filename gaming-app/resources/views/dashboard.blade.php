@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Welcome Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
            Welcome back, {{ $user->username ?? $user->name }}! 🎮
        </h1>
        <p class="text-xl text-gray-600 dark:text-gray-300">
            Ready to climb the leaderboards and unlock achievements?
        </p>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Score -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="text-3xl mr-4">🏆</div>
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Score</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ number_format($user->total_score) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Achievement Points -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="text-3xl mr-4">⭐</div>
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Achievement Points</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ number_format($user->achievement_points) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Games Played -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="text-3xl mr-4">🎮</div>
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Games Played</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ number_format($user->games_played) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Global Rank -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="text-3xl mr-4">🥇</div>
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Global Rank</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">
                        #{{ number_format($globalRank) }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Gaming Progress -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                🎯 Gaming Progress
            </h3>
            
            <div class="space-y-4">
                <!-- Games Completion -->
                <div>
                    <div class="flex justify-between text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        <span>Games Explored</span>
                        <span>{{ $gamesPlayed }}/{{ $totalGames }}</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                             style="width: {{ $completionPercentage }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        {{ $completionPercentage }}% of all games played
                    </p>
                </div>

                <!-- Average Score -->
                <div class="pt-4 border-t dark:border-gray-700">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Average Score</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">
                        {{ number_format($averageScore, 1) }} points
                    </p>
                </div>
            </div>
        </div>

        <!-- Recent Achievements -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                🏅 Recent Achievements
            </h3>
            
            @if($recentAchievements->count() > 0)
                <div class="space-y-3">
                    @foreach($recentAchievements as $achievement)
                        <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="text-2xl mr-3">{{ $achievement->icon }}</div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ $achievement->name }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    +{{ $achievement->points }} points
                                </p>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $achievement->pivot->unlocked_at->diffForHumans() }}
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4 text-center">
                    <a href="{{ route('achievements.index') }}" 
                       class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium">
                        View All Achievements →
                    </a>
                </div>
            @else
                <div class="text-center py-8">
                    <div class="text-4xl mb-2">🏅</div>
                    <p class="text-gray-600 dark:text-gray-400">No achievements yet</p>
                    <p class="text-sm text-gray-500 dark:text-gray-500">Start playing games to unlock achievements!</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Games -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                🎮 Recent Games
            </h3>
            
            @if($recentGames->count() > 0)
                <div class="space-y-3">
                    @foreach($recentGames as $gameScore)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <div class="text-2xl mr-3">
                                    @switch($gameScore->game->category)
                                        @case('puzzle') 🧩 @break
                                        @case('arcade') 🕹️ @break
                                        @case('strategy') ♟️ @break
                                        @case('educational') 📚 @break
                                        @default 🎮
                                    @endswitch
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">
                                        {{ $gameScore->game->name }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Score: {{ number_format($gameScore->score) }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $gameScore->created_at->diffForHumans() }}
                                </p>
                                <a href="{{ route('games.play', $gameScore->game) }}" 
                                   class="text-blue-600 dark:text-blue-400 hover:underline text-xs">
                                    Play Again
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4 text-center">
                    <a href="{{ route('games.index') }}" 
                       class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium">
                        Browse All Games →
                    </a>
                </div>
            @else
                <div class="text-center py-8">
                    <div class="text-4xl mb-2">🎮</div>
                    <p class="text-gray-600 dark:text-gray-400">No games played yet</p>
                    <a href="{{ route('games.index') }}" 
                       class="inline-block mt-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Start Playing
                    </a>
                </div>
            @endif
        </div>

        <!-- Top Scores -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                🏆 Your Top Scores
            </h3>
            
            @if($topScores->count() > 0)
                <div class="space-y-3">
                    @foreach($topScores as $index => $gameScore)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <div class="text-xl mr-3">
                                    @if($index === 0) 🥇
                                    @elseif($index === 1) 🥈
                                    @elseif($index === 2) 🥉
                                    @else {{ $index + 1 }}. @endif
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">
                                        {{ $gameScore->game->name }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ number_format($gameScore->score) }} points
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <a href="{{ route('games.show', $gameScore->game) }}" 
                                   class="text-blue-600 dark:text-blue-400 hover:underline text-xs">
                                    View Game
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4 text-center">
                    <a href="{{ route('profile') }}" 
                       class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium">
                        View Full Profile →
                    </a>
                </div>
            @else
                <div class="text-center py-8">
                    <div class="text-4xl mb-2">🏆</div>
                    <p class="text-gray-600 dark:text-gray-400">No scores yet</p>
                    <p class="text-sm text-gray-500 dark:text-gray-500">Play some games to see your best scores!</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
            ⚡ Quick Actions
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('games.index') }}" 
               class="flex items-center p-4 bg-blue-50 dark:bg-blue-900 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800 transition">
                <div class="text-2xl mr-3">🎮</div>
                <div>
                    <p class="font-medium text-blue-900 dark:text-blue-100">Browse Games</p>
                    <p class="text-sm text-blue-700 dark:text-blue-300">Discover new games to play</p>
                </div>
            </a>
            
            <a href="{{ route('leaderboard') }}" 
               class="flex items-center p-4 bg-green-50 dark:bg-green-900 rounded-lg hover:bg-green-100 dark:hover:bg-green-800 transition">
                <div class="text-2xl mr-3">🏆</div>
                <div>
                    <p class="font-medium text-green-900 dark:text-green-100">Leaderboard</p>
                    <p class="text-sm text-green-700 dark:text-green-300">See top players</p>
                </div>
            </a>
            
            <a href="{{ route('achievements.index') }}" 
               class="flex items-center p-4 bg-purple-50 dark:bg-purple-900 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-800 transition">
                <div class="text-2xl mr-3">🏅</div>
                <div>
                    <p class="font-medium text-purple-900 dark:text-purple-100">Achievements</p>
                    <p class="text-sm text-purple-700 dark:text-purple-300">Track your progress</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
