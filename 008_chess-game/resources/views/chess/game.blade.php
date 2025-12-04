@extends('layouts.app')

@section('title', 'Game #' . $game->id)
@section('content')
<div class="chess-container">
    <div class="row">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Game #{{ $game->id }}</h2>
                <span class="badge bg-{{ $game->board_state['turn'] === 'white' ? 'light' : 'dark' }} text-{{ $game->board_state['turn'] === 'white' ? 'dark' : 'light' }} p-2">
                    Turn: {{ ucfirst($game->board_state['turn']) }}
                </span>
            </div>

            <div id="chess-board" class="chess-board mb-4">
                @foreach($game->board_state['board'] as $row => $rowPieces)
                    <div class="chess-row">
                        @foreach($rowPieces as $col => $piece)
                            <div class="chess-square 
                                        {{ ($row + $col) % 2 === 0 ? 'light' : 'dark' }}
                                        square-{{ $row }}-{{ $col }}"
                                 data-row="{{ $row }}"
                                 data-col="{{ $col }}">
                                @if($piece)
                                    <span class="chess-piece {{ $piece === strtolower($piece) ? 'black-piece' : 'white-piece' }}">
                                        {{ getPieceSymbol($piece) }}
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

            <div class="players-info">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-circle-fill text-light"></i> White</h5>
                                <p class="card-text">{{ $game->player_white ?? 'Waiting for player...' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-circle-fill text-dark"></i> Black</h5>
                                <p class="card-text">{{ $game->player_black ?? 'Waiting for player...' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-clock-history"></i> Moves History</h5>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    <div id="moves-list">
                        @foreach($game->board_state['moves'] as $index => $move)
                            <div class="move-item">
                                <span class="move-number">{{ $index + 1 }}.</span>
                                <span class="move-notation">{{ $move }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @if($game->status === 'completed')
                <div class="alert alert-success mt-3">
                    <h4><i class="bi bi-trophy"></i> Game Over!</h4>
                    <p class="mb-0">Winner: {{ ucfirst($game->winner) }}</p>
                </div>
            @endif

            <div class="mt-3">
                <a href="{{ route('chess.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Games
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/chess.js') }}"></script>
<script>
    const gameId = {{ $game->id }};
    const currentTurn = '{{ $game->board_state["turn"] }}';
</script>
@endpush
@endsection

<?php
// This PHP function is defined at the bottom of the file, outside Blade directives
function getPieceSymbol($piece) {
    $symbols = [
        'p' => '♟', 'r' => '♜', 'n' => '♞', 'b' => '♝', 'q' => '♛', 'k' => '♚',
        'P' => '♙', 'R' => '♖', 'N' => '♘', 'B' => '♗', 'Q' => '♕', 'K' => '♔'
    ];
    return $symbols[$piece] ?? '';
}
?>