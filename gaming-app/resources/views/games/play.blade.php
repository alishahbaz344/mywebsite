@extends('layouts.app')

@section('title', 'Play ' . $game->name)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Game Header -->
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
            {{ $game->name }}
        </h1>
        <p class="text-xl text-gray-600 dark:text-gray-300">
            {{ $game->description }}
        </p>
    </div>

    <!-- Game Container -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <!-- Game Stats Bar -->
        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-b dark:border-gray-600">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center space-x-6">
                    <div class="text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Score:</span>
                        <span id="current-score" class="font-bold text-gray-900 dark:text-white">0</span>
                    </div>
                    @if($game->time_limit)
                        <div class="text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Time:</span>
                            <span id="time-remaining" class="font-bold text-gray-900 dark:text-white">{{ $game->time_limit }}</span>s
                        </div>
                    @endif
                    <div class="text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Difficulty:</span>
                        <span class="font-bold 
                            @if($game->difficulty_level === 'easy') text-green-600
                            @elseif($game->difficulty_level === 'medium') text-yellow-600
                            @else text-red-600 @endif">
                            {{ ucfirst($game->difficulty_level) }}
                        </span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button id="pause-btn" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                        Pause
                    </button>
                    <button id="restart-btn" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                        Restart
                    </button>
                </div>
            </div>
        </div>

        <!-- Game Area -->
        <div class="p-8">
            <div id="game-area" class="min-h-96">
                <!-- Number Guessing Game -->
                @if($game->slug === 'number-guessing')
                    <div id="number-guessing-game" class="text-center">
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                                Guess the Number!
                            </h2>
                            <p class="text-gray-600 dark:text-gray-300">
                                I'm thinking of a number between 1 and 100. Can you guess it?
                            </p>
                        </div>

                        <div class="max-w-md mx-auto space-y-6">
                            <div>
                                <input type="number" 
                                       id="guess-input" 
                                       min="1" 
                                       max="100" 
                                       placeholder="Enter your guess..."
                                       class="w-full px-4 py-3 text-lg text-center border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                            </div>
                            
                            <button id="submit-guess" 
                                    class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition font-semibold text-lg">
                                Submit Guess
                            </button>

                            <div id="feedback" class="text-lg font-medium min-h-8"></div>
                            
                            <div class="grid grid-cols-2 gap-4 text-sm text-gray-600 dark:text-gray-400">
                                <div>
                                    <span class="block">Guesses Used:</span>
                                    <span id="guesses-count" class="font-bold text-gray-900 dark:text-white text-lg">0</span>
                                </div>
                                <div>
                                    <span class="block">Max Guesses:</span>
                                    <span class="font-bold text-gray-900 dark:text-white text-lg">10</span>
                                </div>
                            </div>

                            <div id="guess-history" class="mt-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Your Guesses:</h3>
                                <div id="history-list" class="flex flex-wrap gap-2 justify-center"></div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Placeholder for other games -->
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">🎮</div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                            Game Coming Soon!
                        </h2>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">
                            This game is still in development. Check back later!
                        </p>
                        <a href="{{ route('games.index') }}" 
                           class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                            Browse Other Games
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Game Instructions -->
    <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
            How to Play
        </h3>
        <div class="text-gray-600 dark:text-gray-300 space-y-2">
            @if($game->slug === 'number-guessing')
                <p>• I'll think of a random number between 1 and 100</p>
                <p>• You have up to 10 guesses to find it</p>
                <p>• I'll tell you if your guess is too high or too low</p>
                <p>• Fewer guesses = higher score!</p>
                <p>• Score formula: 1000 - (guesses_used * 100) + time_bonus</p>
            @else
                <p>{{ $game->description }}</p>
            @endif
        </div>
    </div>
</div>

<!-- Game Over Modal -->
<div id="game-over-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-8 max-w-md w-full mx-4">
        <div class="text-center">
            <div id="modal-icon" class="text-6xl mb-4">🎉</div>
            <h3 id="modal-title" class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                Congratulations!
            </h3>
            <p id="modal-message" class="text-gray-600 dark:text-gray-300 mb-6"></p>
            
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="block text-gray-600 dark:text-gray-400">Final Score</span>
                        <span id="final-score" class="font-bold text-xl text-gray-900 dark:text-white">0</span>
                    </div>
                    <div>
                        <span class="block text-gray-600 dark:text-gray-400">Time Taken</span>
                        <span id="time-taken" class="font-bold text-xl text-gray-900 dark:text-white">0s</span>
                    </div>
                </div>
            </div>

            <div class="flex space-x-4">
                <button id="play-again-btn" class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition">
                    Play Again
                </button>
                <a href="{{ route('games.index') }}" 
                   class="flex-1 bg-gray-600 text-white py-3 px-6 rounded-lg hover:bg-gray-700 transition text-center">
                    Browse Games
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Game state
let gameState = {
    gameData: @json($game->game_data),
    gameSlug: '{{ $game->slug }}',
    currentScore: 0,
    startTime: Date.now(),
    timeLimit: {{ $game->time_limit ?? 'null' }},
    isGameActive: false,
    isPaused: false
};

// Initialize game
document.addEventListener('DOMContentLoaded', function() {
    if (gameState.gameSlug === 'number-guessing') {
        initNumberGuessingGame();
    }
    
    // Add event listeners for common controls
    document.getElementById('restart-btn').addEventListener('click', restartGame);
    document.getElementById('pause-btn').addEventListener('click', togglePause);
    document.getElementById('play-again-btn').addEventListener('click', restartGame);
});

function initNumberGuessingGame() {
    gameState.targetNumber = Math.floor(Math.random() * 100) + 1;
    gameState.guessesUsed = 0;
    gameState.maxGuesses = 10;
    gameState.isGameActive = true;
    gameState.currentScore = 0;
    
    const guessInput = document.getElementById('guess-input');
    const submitBtn = document.getElementById('submit-guess');
    
    submitBtn.addEventListener('click', makeGuess);
    guessInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            makeGuess();
        }
    });
    
    updateDisplay();
}

function makeGuess() {
    if (!gameState.isGameActive || gameState.isPaused) return;
    
    const guessInput = document.getElementById('guess-input');
    const guess = parseInt(guessInput.value);
    
    if (!guess || guess < 1 || guess > 100) {
        showFeedback('Please enter a number between 1 and 100!', 'error');
        return;
    }
    
    gameState.guessesUsed++;
    addToHistory(guess);
    
    if (guess === gameState.targetNumber) {
        // Win condition
        const timeTaken = Math.floor((Date.now() - gameState.startTime) / 1000);
        const timeBonus = Math.max(0, (gameState.timeLimit || 300) - timeTaken) * 2;
        gameState.currentScore = Math.max(0, 1000 - (gameState.guessesUsed * 100) + timeBonus);
        
        showFeedback('🎉 Correct! You found the number!', 'success');
        endGame(true, `You guessed ${gameState.targetNumber} in ${gameState.guessesUsed} tries!`);
    } else if (gameState.guessesUsed >= gameState.maxGuesses) {
        // Lose condition
        showFeedback(`💀 Game Over! The number was ${gameState.targetNumber}`, 'error');
        endGame(false, `You've used all your guesses. The number was ${gameState.targetNumber}.`);
    } else {
        // Continue playing
        const hint = guess < gameState.targetNumber ? 'Too low! Try higher.' : 'Too high! Try lower.';
        showFeedback(hint, 'info');
    }
    
    guessInput.value = '';
    updateDisplay();
}

function showFeedback(message, type) {
    const feedback = document.getElementById('feedback');
    feedback.textContent = message;
    feedback.className = `text-lg font-medium min-h-8 ${
        type === 'success' ? 'text-green-600' :
        type === 'error' ? 'text-red-600' :
        'text-blue-600'
    }`;
}

function addToHistory(guess) {
    const historyList = document.getElementById('history-list');
    const guessElement = document.createElement('span');
    guessElement.className = 'px-3 py-1 bg-gray-200 dark:bg-gray-600 rounded-full text-sm';
    guessElement.textContent = guess;
    historyList.appendChild(guessElement);
}

function updateDisplay() {
    document.getElementById('current-score').textContent = gameState.currentScore;
    document.getElementById('guesses-count').textContent = gameState.guessesUsed;
    
    if (gameState.timeLimit) {
        const elapsed = Math.floor((Date.now() - gameState.startTime) / 1000);
        const remaining = Math.max(0, gameState.timeLimit - elapsed);
        document.getElementById('time-remaining').textContent = remaining;
        
        if (remaining === 0 && gameState.isGameActive) {
            endGame(false, "Time's up!");
        }
    }
}

function endGame(won, message) {
    gameState.isGameActive = false;
    
    const timeTaken = Math.floor((Date.now() - gameState.startTime) / 1000);
    
    // Update modal
    document.getElementById('modal-icon').textContent = won ? '🎉' : '💀';
    document.getElementById('modal-title').textContent = won ? 'Congratulations!' : 'Game Over';
    document.getElementById('modal-message').textContent = message;
    document.getElementById('final-score').textContent = gameState.currentScore;
    document.getElementById('time-taken').textContent = timeTaken + 's';
    
    // Show modal
    document.getElementById('game-over-modal').classList.remove('hidden');
    
    // Submit score if user is authenticated
    @auth
        submitScore(gameState.currentScore, timeTaken);
    @endauth
}

function restartGame() {
    // Hide modal
    document.getElementById('game-over-modal').classList.add('hidden');
    
    // Clear game area
    document.getElementById('history-list').innerHTML = '';
    document.getElementById('feedback').textContent = '';
    document.getElementById('guess-input').value = '';
    
    // Reset state
    gameState.startTime = Date.now();
    gameState.currentScore = 0;
    gameState.isPaused = false;
    
    // Reinitialize
    if (gameState.gameSlug === 'number-guessing') {
        initNumberGuessingGame();
    }
}

function togglePause() {
    gameState.isPaused = !gameState.isPaused;
    const pauseBtn = document.getElementById('pause-btn');
    pauseBtn.textContent = gameState.isPaused ? 'Resume' : 'Pause';
    pauseBtn.className = gameState.isPaused 
        ? 'px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition'
        : 'px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition';
}

@auth
function submitScore(score, timeTaken) {
    fetch(`{{ route('games.submit-score', $game) }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            score: score,
            time_taken: timeTaken,
            game_data: {
                target_number: gameState.targetNumber,
                guesses_used: gameState.guessesUsed
            }
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Score submitted successfully!');
            if (data.is_new_best) {
                showFeedback('🎉 New personal best!', 'success');
            }
        }
    })
    .catch(error => {
        console.error('Error submitting score:', error);
    });
}
@endauth

// Update display every second
setInterval(updateDisplay, 1000);
</script>
@endsection