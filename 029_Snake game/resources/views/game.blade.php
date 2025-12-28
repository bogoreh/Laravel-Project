@extends('layouts.app')

@section('content')
<div class="game-wrapper">
    <header class="game-header">
        <h1><i class="fas fa-gamepad"></i> Laravel Snake</h1>
        <p class="subtitle">Classic Snake Game with Modern Design</p>
    </header>

    <div class="game-container">
        <div class="game-board">
            <div class="game-info">
                <div class="score-board">
                    <div class="score-item">
                        <span class="label">SCORE</span>
                        <span id="score" class="value">0</span>
                    </div>
                    <div class="score-item">
                        <span class="label">LEVEL</span>
                        <span id="level" class="value">1</span>
                    </div>
                    <div class="score-item">
                        <span class="label">LENGTH</span>
                        <span id="length" class="value">3</span>
                    </div>
                    <div class="score-item">
                        <span class="label">HIGH SCORE</span>
                        <span id="high-score" class="value">{{ $highScores->first()->score ?? 0 }}</span>
                    </div>
                </div>
                
                <div class="controls">
                    <button id="start-btn" class="btn btn-primary">
                        <i class="fas fa-play"></i> Start Game
                    </button>
                    <button id="pause-btn" class="btn btn-secondary" disabled>
                        <i class="fas fa-pause"></i> Pause
                    </button>
                    <button id="restart-btn" class="btn btn-warning">
                        <i class="fas fa-redo"></i> Restart
                    </button>
                </div>
                
                <div class="instructions">
                    <h3><i class="fas fa-info-circle"></i> Controls</h3>
                    <p>Use <kbd>↑</kbd> <kbd>↓</kbd> <kbd>←</kbd> <kbd>→</kbd> or <kbd>W</kbd> <kbd>A</kbd> <kbd>S</kbd> <kbd>D</kbd> to move</p>
                    <p>Press <kbd>SPACE</kbd> to pause/resume</p>
                </div>
            </div>

            <div class="game-area">
                <canvas id="gameCanvas" width="600" height="600"></canvas>
                <div id="game-over" class="game-over">
                    <h2>Game Over!</h2>
                    <p>Your Score: <span id="final-score">0</span></p>
                    <div class="save-score">
                        <input type="text" id="player-name" placeholder="Enter your name" maxlength="50">
                        <button id="save-score-btn" class="btn btn-success">
                            <i class="fas fa-save"></i> Save Score
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="high-scores">
            <h2><i class="fas fa-trophy"></i> High Scores</h2>
            <div id="scores-list">
                @foreach($highScores as $index => $score)
                <div class="score-row">
                    <span class="rank">#{{ $index + 1 }}</span>
                    <span class="player">{{ $score->player_name }}</span>
                    <span class="points">{{ $score->score }}</span>
                    <span class="level">Level {{ $score->level }}</span>
                </div>
                @endforeach
            </div>
            <button id="refresh-scores" class="btn btn-outline">
                <i class="fas fa-sync-alt"></i> Refresh Scores
            </button>
        </div>
    </div>

    <footer class="game-footer">
        <p>Built with Laravel & JavaScript • Use arrow keys to play</p>
    </footer>
</div>
@endsection