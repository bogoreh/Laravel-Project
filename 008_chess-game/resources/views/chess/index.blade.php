@extends('layouts.app')

@section('title', 'Chess Games')
@section('content')
<div class="chess-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-chess-knight"></i> Chess Games</h1>
        <form action="{{ route('chess.create') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle"></i> New Game
            </button>
        </form>
    </div>

    @if($games->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-chess-board display-1 text-muted"></i>
            <h3 class="mt-3">No active games</h3>
            <p class="text-muted">Start a new chess game to begin playing!</p>
        </div>
    @else
        <div class="row">
            @foreach($games as $game)
                <div class="col-md-4 mb-4">
                    <div class="card game-card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Game #{{ $game->id }}</h5>
                            <p class="card-text">
                                <span class="badge bg-{{ $game->status === 'ongoing' ? 'success' : 'warning' }}">
                                    {{ ucfirst($game->status) }}
                                </span>
                                <br>
                                <small class="text-muted">
                                    Created: {{ $game->created_at->diffForHumans() }}
                                </small>
                            </p>
                            <div class="player-info">
                                <p>
                                    <i class="bi bi-circle-fill text-light"></i> 
                                    White: {{ $game->player_white ?? 'Waiting...' }}
                                </p>
                                <p>
                                    <i class="bi bi-circle-fill text-dark"></i> 
                                    Black: {{ $game->player_black ?? 'Waiting...' }}
                                </p>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('chess.game', $game->id) }}" class="btn btn-outline-primary">
                                <i class="bi bi-play-circle"></i> Play
                            </a>
                            @if(!$game->player_white)
                                <a href="{{ route('game.join', ['id' => $game->id, 'color' => 'white']) }}" 
                                   class="btn btn-outline-secondary btn-sm">
                                    Join as White
                                </a>
                            @endif
                            @if(!$game->player_black)
                                <a href="{{ route('game.join', ['id' => $game->id, 'color' => 'black']) }}" 
                                   class="btn btn-outline-dark btn-sm">
                                    Join as Black
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection