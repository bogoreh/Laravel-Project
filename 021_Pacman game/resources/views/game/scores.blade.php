@extends('layout.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-5">🏆 High Scores</h1>
    
    <div class="row">
        <div class="col-md-8 offset-md-2">
            @if($scores->count() > 0)
            <div class="table-responsive">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Player</th>
                            <th>Score</th>
                            <th>Level</th>
                            <th>Lives</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($scores as $index => $score)
                        <tr class="score-item">
                            <td>#{{ $index + 1 }}</td>
                            <td>{{ $score->player_name }}</td>
                            <td class="text-warning">{{ number_format($score->score) }}</td>
                            <td>{{ $score->level }}</td>
                            <td>{{ $score->lives }}</td>
                            <td>{{ $score->created_at->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center">
                <div class="alert alert-info">
                    <h4>No scores yet!</h4>
                    <p>Be the first to play and set a high score!</p>
                    <a href="{{ route('game.play') }}" class="btn btn-warning btn-lg">Play Now</a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection