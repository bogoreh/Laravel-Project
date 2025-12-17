@extends('layout.app')

@section('content')
<div class="container text-center">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="game-header mb-5">
                <h1 class="display-4" style="font-family: 'Press Start 2P', cursive; color: yellow;">
                    PAC<span style="color: white;">MAN</span>
                </h1>
                <p class="lead">A classic arcade game recreated with Laravel</p>
            </div>

            <div class="game-options row mt-5">
                <div class="col-md-6 mb-4">
                    <div class="card game-card h-100">
                        <div class="card-body">
                            <h3 class="card-title">🎮 Play Now</h3>
                            <p class="card-text">Start playing the classic Pacman game</p>
                            <a href="{{ route('game.play') }}" class="btn btn-warning btn-lg">Start Game</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="card game-card h-100">
                        <div class="card-body">
                            <h3 class="card-title">🏆 High Scores</h3>
                            <p class="card-text">Check out the top players</p>
                            <a href="{{ route('game.scores') }}" class="btn btn-primary btn-lg">View Scores</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="card game-card h-100">
                        <div class="card-body">
                            <h3 class="card-title">🎥 Videos</h3>
                            <p class="card-text">Watch Pacman gameplay and tutorials</p>
                            <a href="{{ route('videos.index') }}" class="btn btn-success btn-lg">Watch Videos</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="card game-card h-100">
                        <div class="card-body">
                            <h3 class="card-title">⚙️ How to Play</h3>
                            <p class="card-text">Use arrow keys to move Pacman</p>
                            <ul class="text-start">
                                <li>Eat dots for points</li>
                                <li>Avoid ghosts</li>
                                <li>Eat power pellets to turn the tables</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection