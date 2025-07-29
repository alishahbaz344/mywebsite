@extends('layouts.app')

@section('title', 'Browse Games')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
            🎮 Explore Games
        </h1>
        <p class="text-xl text-gray-600 dark:text-gray-300">
            Choose from our collection of exciting games and compete for the highest scores!
        </p>
    </div>

    <!-- Search and Filters -->
    <div class="mb-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <form method="GET" action="{{ route('games.index') }}" class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Search Games
                </label>
                <input type="text" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search by game name..."
                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Category Filter -->
            <div class="md:w-48">
                <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Category
                </label>
                <select id="category" 
                        name="category"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>
                            {{ ucfirst($cat) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <div class="md:w-32 flex items-end">
                <button type="submit" 
                        class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Games Grid -->
    @if($games->count() > 0)
        <div class="game-grid mb-8">
            @foreach($games as $game)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden card-hover">
                    <!-- Game Image/Icon -->
                    <div class="h-48 gradient-bg flex items-center justify-center">
                        @if($game->image_url)
                            <img src="{{ $game->image_url }}" alt="{{ $game->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-6xl text-white">
                                @switch($game->category)
                                    @case('puzzle')
                                        🧩
                                        @break
                                    @case('arcade')
                                        🕹️
                                        @break
                                    @case('strategy')
                                        ♟️
                                        @break
                                    @case('educational')
                                        📚
                                        @break
                                    @default
                                        🎮
                                @endswitch
                            </div>
                        @endif
                    </div>

                    <!-- Game Info -->
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                {{ $game->name }}
                            </h3>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($game->difficulty_level === 'easy') bg-green-100 text-green-800
                                @elseif($game->difficulty_level === 'medium') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($game->difficulty_level) }}
                            </span>
                        </div>

                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-3">
                            {{ $game->description }}
                        </p>

                        <!-- Game Stats -->
                        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                            <span class="flex items-center">
                                🏆 High: {{ number_format($game->getHighestScore()) }}
                            </span>
                            <span class="flex items-center">
                                👥 {{ number_format($game->plays_count) }} plays
                            </span>
                        </div>

                        <!-- Category Badge -->
                        <div class="mb-4">
                            <span class="inline-block px-3 py-1 text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-full">
                                {{ ucfirst($game->category) }}
                            </span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('games.show', $game) }}" 
                               class="flex-1 text-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                                View Details
                            </a>
                            <a href="{{ route('games.play', $game) }}" 
                               class="flex-1 text-center bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition font-medium">
                                Play Now
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $games->withQueryString()->links() }}
        </div>
    @else
        <!-- No Games Found -->
        <div class="text-center py-12">
            <div class="text-6xl mb-4">🎮</div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No Games Found</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-4">
                @if(request('search') || request('category'))
                    Try adjusting your search criteria or browse all games.
                @else
                    Check back later for new games!
                @endif
            </p>
            @if(request('search') || request('category'))
                <a href="{{ route('games.index') }}" 
                   class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-medium">
                    View All Games
                </a>
            @endif
        </div>
    @endif
</div>

<!-- Quick Stats Section -->
@if($games->count() > 0)
<div class="bg-white dark:bg-gray-800 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-8">
            Game Statistics
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-4xl font-bold text-blue-600 dark:text-blue-400">
                    {{ $games->total() }}
                </div>
                <div class="text-gray-600 dark:text-gray-300 mt-2">Total Games</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-green-600 dark:text-green-400">
                    {{ $categories->count() }}
                </div>
                <div class="text-gray-600 dark:text-gray-300 mt-2">Categories</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-purple-600 dark:text-purple-400">
                    {{ number_format($games->sum('plays_count')) }}
                </div>
                <div class="text-gray-600 dark:text-gray-300 mt-2">Total Plays</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-yellow-600 dark:text-yellow-400">
                    @auth {{ auth()->user()->games_played }} @else 0 @endauth
                </div>
                <div class="text-gray-600 dark:text-gray-300 mt-2">Your Games Played</div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection