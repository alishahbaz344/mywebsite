<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\AchievementController;
use Illuminate\Support\Facades\Route;

// Home page - redirect to games
Route::get('/', [GameController::class, 'index'])->name('home');

// Games routes
Route::prefix('games')->name('games.')->group(function () {
    Route::get('/', [GameController::class, 'index'])->name('index');
    Route::get('/category/{category}', [GameController::class, 'byCategory'])->name('category');
    Route::get('/{game}', [GameController::class, 'show'])->name('show');
    Route::get('/{game}/play', [GameController::class, 'play'])->name('play');
    Route::get('/{game}/data', [GameController::class, 'gameData'])->name('data');
    
    // Authenticated routes for scores
    Route::middleware('auth')->group(function () {
        Route::post('/{game}/score', [GameController::class, 'submitScore'])->name('submit-score');
    });
});

// Dashboard routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::patch('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
});

// Leaderboard routes
Route::get('/leaderboard', [DashboardController::class, 'leaderboard'])->name('leaderboard');

// Achievement routes
Route::prefix('achievements')->name('achievements.')->group(function () {
    Route::get('/', [AchievementController::class, 'index'])->name('index');
    Route::get('/{achievement}', [AchievementController::class, 'show'])->name('show');
});

// Original profile routes (for compatibility)
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/original', [ProfileController::class, 'update'])->name('profile.original.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
