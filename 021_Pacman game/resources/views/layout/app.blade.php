<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Pacman Game</title>
    <link rel="stylesheet" href="{{ asset('css/game.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <span style="color: yellow;">●▶</span> Laravel Pacman
            </a>
            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('game.index') }}">Home</a>
                <a class="nav-link" href="{{ route('game.play') }}">Play Game</a>
                <a class="nav-link" href="{{ route('game.scores') }}">High Scores</a>
                <a class="nav-link" href="{{ route('videos.index') }}">Videos</a>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        @yield('content')
    </main>

    <footer class="footer mt-5 py-3 bg-dark text-white">
        <div class="container text-center">
            <span>Laravel Pacman Game © {{ date('Y') }}</span>
        </div>
    </footer>

    <script src="{{ asset('js/game.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>