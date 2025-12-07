@extends('layouts.app')

@section('content')
    <h1 class="game-title">
        <i class="fas fa-gamepad me-2"></i>Tic Tac Toe
    </h1>
    
    <!-- Game Mode Selector -->
    <div class="game-mode-selector">
        <div class="d-flex justify-content-between">
            <form action="{{ route('tictactoe.change-mode') }}" method="POST" class="d-flex w-100">
                @csrf
                <button type="submit" name="mode" value="pvp" 
                        class="mode-btn me-2 {{ $gameMode === 'pvp' ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i>
                    <span>Player vs Player</span>
                </button>
                <button type="submit" name="mode" value="pvc" 
                        class="mode-btn {{ $gameMode === 'pvc' ? 'active' : '' }}">
                    <i class="fas fa-robot me-2"></i>
                    <span>Player vs Computer</span>
                </button>
            </form>
        </div>
    </div>
    
    <!-- Game Status -->
    <div class="status-card {{ $winner ? ($winner === 'Draw' ? 'draw-animation' : 'winner-animation') : '' }}">
        @if($winner)
            @if($winner === 'Draw')
                <h3 class="text-warning mb-3">
                    <i class="fas fa-handshake me-2"></i>Game Draw!
                </h3>
                <p class="text-muted mb-0">No winner this time. Try again!</p>
            @else
                <h3 class="text-success mb-3">
                    <i class="fas fa-trophy me-2"></i>Victory!
                </h3>
                <p class="mb-0">
                    <span class="player-indicator" style="min-width: auto; padding: 8px 16px;">
                        Player {{ $winner }}
                    </span>
                    <span class="mx-2">has won the game!</span>
                </p>
            @endif
        @else
            <h4 class="text-secondary mb-3">Current Player</h4>
            <div class="d-flex justify-content-center align-items-center">
                <span class="player-indicator {{ $currentPlayer === 'X' ? 'active' : '' }}">
                    <i class="fas fa-times me-2"></i>Player X
                </span>
                <span class="mx-3 text-muted">VS</span>
                <span class="player-indicator {{ $currentPlayer === 'O' ? 'active' : '' }}">
                    <i class="fas fa-circle me-2"></i>{{ $gameMode === 'pvc' ? 'Computer' : 'Player O' }}
                </span>
            </div>
            <div class="mt-3">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    {{ $currentPlayer === 'X' ? 'X' : ($gameMode === 'pvc' ? 'Computer' : 'O') }}'s turn
                </small>
            </div>
        @endif
    </div>
    
    <!-- Game Board -->
    <div class="game-board">
        @for($i = 0; $i < 3; $i++)
            @for($j = 0; $j < 3; $j++)
                @if($board[$i][$j] || $gameOver)
                    <div class="cell {{ $board[$i][$j] ? $board[$i][$j] : '' }} disabled">
                        {{ $board[$i][$j] }}
                    </div>
                @else
                    <form action="{{ route('tictactoe.move') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="row" value="{{ $i }}">
                        <input type="hidden" name="col" value="{{ $j }}">
                        <button type="submit" class="cell border-0 p-0 w-100">
                            &nbsp;
                        </button>
                    </form>
                @endif
            @endfor
        @endfor
    </div>
    
    <!-- Game Controls -->
    <div class="controls">
        <form action="{{ route('tictactoe.reset') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-custom reset">
                <i class="fas fa-redo me-2"></i>New Game
            </button>
        </form>
        
        @if($gameMode === 'pvc')
            <div class="mt-3 text-muted">
                <small>
                    <i class="fas fa-microchip me-1"></i>
                    Playing against AI opponent
                </small>
            </div>
        @endif
    </div>
    
    <!-- Game Instructions -->
    <div class="instructions">
        <h5>
            <i class="fas fa-lightbulb"></i>
            Game Instructions
        </h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="d-flex align-items-center">
                    <span class="cell x me-3" style="width: 50px; height: 50px; font-size: 1.8rem;">X</span>
                    <div>
                        <strong class="d-block">Player X</strong>
                        <small class="text-muted">Makes the first move</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="d-flex align-items-center">
                    <span class="cell o me-3" style="width: 50px; height: 50px; font-size: 1.8rem;">O</span>
                    <div>
                        <strong class="d-block">{{ $gameMode === 'pvc' ? 'Computer' : 'Player O' }}</strong>
                        <small class="text-muted">Second player</small>
                    </div>
                </div>
            </div>
        </div>
        <p class="mb-0 text-secondary">
            <i class="fas fa-flag me-1"></i>
            Get three of your symbols in a row (horizontally, vertically, or diagonally) to win the game.
        </p>
    </div>
    
    <!-- Game Info -->
    <div class="game-info">
        <small>
            <i class="fas fa-code me-1"></i>
            Built with Laravel • 
            <i class="fas fa-palette ms-3 me-1"></i>
            Dark Professional Theme
        </small>
    </div>
@endsection