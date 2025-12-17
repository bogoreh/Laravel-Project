<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Pacman Game</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a1a2e;
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .welcome-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)), 
                        url('https://images.unsplash.com/photo-1550745165-9bc0b252726f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
        }
        .game-title {
            font-family: 'Press Start 2P', cursive;
            color: yellow;
            text-shadow: 3px 3px 0 #000;
            margin-bottom: 30px;
        }
        .start-btn {
            background: yellow;
            color: black;
            font-weight: bold;
            padding: 15px 40px;
            font-size: 1.5rem;
            border-radius: 10px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .start-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 0 20px yellow;
            color: black;
        }
        .features {
            margin-top: 50px;
        }
        .feature-item {
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid yellow;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <div class="container text-center">
            <h1 class="game-title display-1">PAC-MAN</h1>
            <p class="lead fs-3 mb-4">Classic Arcade Game in Laravel</p>
            
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <a href="/game" class="start-btn">START GAME</a>
                    
                    <div class="features">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="feature-item">
                                    <h4>🎮 Play Game</h4>
                                    <p>Classic Pacman gameplay</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-item">
                                    <h4>🏆 High Scores</h4>
                                    <p>Compete with other players</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-item">
                                    <h4>🎥 Videos</h4>
                                    <p>Watch gameplay videos</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-5">
                        <p class="text-muted">Created with Laravel • HTML5 Canvas • Bootstrap</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>