@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="game-container">
                <div class="game-header mb-3">
                    <h2>Pacman Game</h2>
                    <div class="game-stats">
                        <span class="stat">Score: <span id="score">0</span></span>
                        <span class="stat">Level: <span id="level">1</span></span>
                        <span class="stat">Lives: <span id="lives">3</span></span>
                    </div>
                </div>

                <canvas id="gameCanvas" width="800" height="600"></canvas>
                
                <div class="game-controls mt-3">
                    <button id="startBtn" class="btn btn-success">Start Game</button>
                    <button id="pauseBtn" class="btn btn-warning">Pause</button>
                    <button id="resetBtn" class="btn btn-danger">Reset</button>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Game Controls</h4>
                </div>
                <div class="card-body">
                    <div class="controls-info">
                        <div class="control-item">
                            <span class="key">↑</span> Move Up
                        </div>
                        <div class="control-item">
                            <span class="key">↓</span> Move Down
                        </div>
                        <div class="control-item">
                            <span class="key">←</span> Move Left
                        </div>
                        <div class="control-item">
                            <span class="key">→</span> Move Right
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <h5>Save Your Score</h5>
                        <div class="mb-3">
                            <input type="text" id="playerName" class="form-control" placeholder="Enter your name" maxlength="50">
                        </div>
                        <button id="saveScoreBtn" class="btn btn-primary" disabled>Save Score</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Game variables
    const canvas = document.getElementById('gameCanvas');
    const ctx = canvas.getContext('2d');
    let gameRunning = false;
    let gameScore = 0;
    let gameLevel = 1;
    let gameLives = 3;
    
    // Pacman properties
    let pacman = {
        x: 400,
        y: 300,
        radius: 20,
        speed: 5,
        direction: 0, // 0: right, 1: down, 2: left, 3: up
        mouthOpen: 0,
        mouthSpeed: 0.1
    };
    
    // Dots array
    let dots = [];
    
    // Initialize dots
    function initDots() {
        dots = [];
        for(let i = 0; i < 50; i++) {
            dots.push({
                x: Math.random() * (canvas.width - 40) + 20,
                y: Math.random() * (canvas.height - 40) + 20,
                radius: 5,
                eaten: false
            });
        }
    }
    
    // Draw Pacman
    function drawPacman() {
        ctx.beginPath();
        ctx.fillStyle = 'yellow';
        
        let startAngle = 0.2 * Math.PI * pacman.mouthOpen;
        let endAngle = (2 - 0.2 * pacman.mouthOpen) * Math.PI;
        
        if(pacman.direction === 1) { // Down
            startAngle = 0.7 * Math.PI * pacman.mouthOpen;
            endAngle = (2.3 - 0.2 * pacman.mouthOpen) * Math.PI;
        } else if(pacman.direction === 2) { // Left
            startAngle = 1.2 * Math.PI * pacman.mouthOpen;
            endAngle = (3.2 - 0.2 * pacman.mouthOpen) * Math.PI;
        } else if(pacman.direction === 3) { // Up
            startAngle = 1.7 * Math.PI * pacman.mouthOpen;
            endAngle = (3.7 - 0.2 * pacman.mouthOpen) * Math.PI;
        }
        
        ctx.arc(pacman.x, pacman.y, pacman.radius, startAngle, endAngle);
        ctx.lineTo(pacman.x, pacman.y);
        ctx.fill();
        
        // Update mouth animation
        pacman.mouthOpen += pacman.mouthSpeed;
        if(pacman.mouthOpen >= 1 || pacman.mouthOpen <= 0) {
            pacman.mouthSpeed *= -1;
        }
    }
    
    // Draw dots
    function drawDots() {
        dots.forEach(dot => {
            if(!dot.eaten) {
                ctx.beginPath();
                ctx.fillStyle = 'white';
                ctx.arc(dot.x, dot.y, dot.radius, 0, Math.PI * 2);
                ctx.fill();
            }
        });
    }
    
    // Update game
    function update() {
        // Move Pacman based on direction
        if(pacman.direction === 0) pacman.x += pacman.speed; // Right
        if(pacman.direction === 1) pacman.y += pacman.speed; // Down
        if(pacman.direction === 2) pacman.x -= pacman.speed; // Left
        if(pacman.direction === 3) pacman.y -= pacman.speed; // Up
        
        // Boundary checking
        if(pacman.x < pacman.radius) pacman.x = pacman.radius;
        if(pacman.x > canvas.width - pacman.radius) pacman.x = canvas.width - pacman.radius;
        if(pacman.y < pacman.radius) pacman.y = pacman.radius;
        if(pacman.y > canvas.height - pacman.radius) pacman.y = canvas.height - pacman.radius;
        
        // Check dot collisions
        dots.forEach(dot => {
            if(!dot.eaten) {
                let dx = pacman.x - dot.x;
                let dy = pacman.y - dot.y;
                let distance = Math.sqrt(dx * dx + dy * dy);
                
                if(distance < pacman.radius + dot.radius) {
                    dot.eaten = true;
                    gameScore += 10;
                    updateScore();
                    
                    // Check if all dots are eaten
                    if(dots.every(d => d.eaten)) {
                        gameLevel++;
                        document.getElementById('level').textContent = gameLevel;
                        initDots();
                    }
                }
            }
        });
    }
    
    // Draw game
    function draw() {
        // Clear canvas
        ctx.fillStyle = 'black';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        
        // Draw game elements
        drawDots();
        drawPacman();
    }
    
    // Game loop
    function gameLoop() {
        if(gameRunning) {
            update();
            draw();
            requestAnimationFrame(gameLoop);
        }
    }
    
    // Update score display
    function updateScore() {
        document.getElementById('score').textContent = gameScore;
    }
    
    // Event Listeners
    document.getElementById('startBtn').addEventListener('click', function() {
        if(!gameRunning) {
            gameRunning = true;
            gameLoop();
        }
    });
    
    document.getElementById('pauseBtn').addEventListener('click', function() {
        gameRunning = !gameRunning;
        if(gameRunning) {
            gameLoop();
        }
    });
    
    document.getElementById('resetBtn').addEventListener('click', function() {
        gameRunning = false;
        gameScore = 0;
        gameLevel = 1;
        gameLives = 3;
        pacman.x = 400;
        pacman.y = 300;
        initDots();
        updateScore();
        document.getElementById('level').textContent = gameLevel;
        document.getElementById('lives').textContent = gameLives;
        draw();
    });
    
    // Keyboard controls
    document.addEventListener('keydown', function(e) {
        switch(e.key) {
            case 'ArrowUp':
                pacman.direction = 3;
                break;
            case 'ArrowDown':
                pacman.direction = 1;
                break;
            case 'ArrowLeft':
                pacman.direction = 2;
                break;
            case 'ArrowRight':
                pacman.direction = 0;
                break;
        }
    });
    
    // Save score
    document.getElementById('saveScoreBtn').addEventListener('click', function() {
        const playerName = document.getElementById('playerName').value;
        
        if(playerName.trim() === '') {
            alert('Please enter your name');
            return;
        }
        
        fetch('{{ route("game.saveScore") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                player_name: playerName,
                score: gameScore,
                level: gameLevel,
                lives: gameLives
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('Score saved successfully!');
                document.getElementById('saveScoreBtn').disabled = true;
            }
        });
    });
    
    // Enable save button when score > 0
    setInterval(() => {
        if(gameScore > 0 && document.getElementById('playerName').value.trim() !== '') {
            document.getElementById('saveScoreBtn').disabled = false;
        }
    }, 1000);
    
    // Initialize game
    initDots();
    draw();
</script>
@endsection
@endsection