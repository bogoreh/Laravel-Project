<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tetris Game - Laravel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-start;
        }

        .game-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .game-header {
            text-align: center;
            margin-bottom: 20px;
            color: white;
        }

        .game-header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .game-wrapper {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .game-board {
            display: grid;
            grid-template-columns: repeat(10, 30px);
            grid-template-rows: repeat(20, 30px);
            gap: 1px;
            background: rgba(0, 0, 0, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 5px;
            padding: 5px;
        }

        .game-board div {
            width: 30px;
            height: 30px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }

        .game-board div.filled {
            border: 2px solid rgba(255, 255, 255, 0.8);
        }

        .game-info {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            color: white;
            min-width: 250px;
        }

        .info-section {
            margin-bottom: 25px;
        }

        .info-section h3 {
            margin-bottom: 10px;
            font-size: 1.3rem;
            color: #ffcc00;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .score-display {
            font-size: 2rem;
            font-weight: bold;
            color: #4cd964;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            margin: 10px 0;
        }

        .controls-info p {
            margin: 8px 0;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .controls-info kbd {
            background: rgba(0, 0, 0, 0.3);
            padding: 2px 8px;
            border-radius: 4px;
            font-family: monospace;
        }

        .game-btn {
            background: linear-gradient(45deg, #4cd964, #5ac8fa);
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 1.1rem;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 10px 5px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .game-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .game-btn:active {
            transform: translateY(1px);
        }

        .game-btn.pause {
            background: linear-gradient(45deg, #ff9500, #ff5e3a);
        }

        .game-btn.restart {
            background: linear-gradient(45deg, #ff3b30, #ff2d55);
        }

        .high-scores {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            color: white;
            min-width: 300px;
            max-height: 600px;
            overflow-y: auto;
        }

        .high-scores h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #ffcc00;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .score-item {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .score-item:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(5px);
        }

        .score-rank {
            font-weight: bold;
            color: #4cd964;
            font-size: 1.2rem;
            min-width: 30px;
        }

        .score-player {
            flex-grow: 1;
            margin: 0 15px;
        }

        .score-value {
            font-weight: bold;
            font-size: 1.1rem;
            color: #5ac8fa;
        }

        .game-over-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            color: white;
            max-width: 400px;
            width: 90%;
        }

        .modal-content h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #ffcc00;
        }

        .modal-content input {
            width: 100%;
            padding: 15px;
            margin: 15px 0;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            background: rgba(255, 255, 255, 0.9);
        }

        .color-I { background: #00f0f0 !important; }
        .color-J { background: #0000f0 !important; }
        .color-L { background: #f0a000 !important; }
        .color-O { background: #f0f000 !important; }
        .color-S { background: #00f000 !important; }
        .color-T { background: #a000f0 !important; }
        .color-Z { background: #f00000 !important; }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
            }
            
            .game-board {
                grid-template-columns: repeat(10, 25px);
                grid-template-rows: repeat(20, 25px);
            }
            
            .game-board div {
                width: 25px;
                height: 25px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="game-container">
            <div class="game-header">
                <h1>🎮 Laravel Tetris</h1>
                <p>Classic puzzle game with modern design</p>
            </div>
            
            <div class="game-wrapper">
                <div>
                    <div class="game-board" id="gameBoard"></div>
                    <div style="text-align: center; margin-top: 20px;">
                        <button class="game-btn" onclick="startGame()">▶ Start</button>
                        <button class="game-btn pause" onclick="pauseGame()">⏸ Pause</button>
                        <button class="game-btn restart" onclick="restartGame()">🔄 Restart</button>
                    </div>
                </div>
                
                <div class="game-info">
                    <div class="info-section">
                        <h3>📊 Game Stats</h3>
                        <div class="score-display" id="score">0</div>
                        <p>Level: <span id="level">1</span></p>
                        <p>Lines: <span id="lines">0</span></p>
                    </div>
                    
                    <div class="info-section">
                        <h3>🎯 Next Piece</h3>
                        <div id="nextPiece" style="height: 60px;"></div>
                    </div>
                    
                    <div class="info-section controls-info">
                        <h3>🎮 Controls</h3>
                        <p><kbd>←</kbd> <kbd>→</kbd> Move Left/Right</p>
                        <p><kbd>↑</kbd> Rotate Piece</p>
                        <p><kbd>↓</kbd> Soft Drop</p>
                        <p><kbd>Space</kbd> Hard Drop</p>
                        <p><kbd>P</kbd> Pause Game</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="high-scores">
            <h2>🏆 High Scores</h2>
            <div id="highScoresList">
                @foreach($highScores as $index => $score)
                <div class="score-item">
                    <div class="score-rank">#{{ $index + 1 }}</div>
                    <div class="score-player">{{ $score->player_name }}</div>
                    <div class="score-value">{{ number_format($score->score) }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="game-over-modal" id="gameOverModal">
        <div class="modal-content">
            <h2>Game Over!</h2>
            <div style="font-size: 2rem; margin: 20px 0;" id="finalScore">0</div>
            <input type="text" id="playerName" placeholder="Enter your name" maxlength="50">
            <div style="margin-top: 20px;">
                <button class="game-btn" onclick="saveScore()">💾 Save Score</button>
                <button class="game-btn restart" onclick="restartGame()">🔄 Play Again</button>
            </div>
        </div>
    </div>

    <script>
        // Game variables
        const boardWidth = 10;
        const boardHeight = 20;
        let board = [];
        let currentPiece = null;
        let nextPiece = null;
        let score = 0;
        let level = 1;
        let lines = 0;
        let gameRunning = false;
        let gameLoop = null;
        let dropSpeed = 1000; // ms
        let lastDropTime = 0;

        // Tetromino definitions
        const tetrominos = [
            { // I
                shape: [
                    [0,0,0,0],
                    [1,1,1,1],
                    [0,0,0,0],
                    [0,0,0,0]
                ],
                color: 'color-I'
            },
            { // J
                shape: [
                    [1,0,0],
                    [1,1,1],
                    [0,0,0]
                ],
                color: 'color-J'
            },
            { // L
                shape: [
                    [0,0,1],
                    [1,1,1],
                    [0,0,0]
                ],
                color: 'color-L'
            },
            { // O
                shape: [
                    [1,1],
                    [1,1]
                ],
                color: 'color-O'
            },
            { // S
                shape: [
                    [0,1,1],
                    [1,1,0],
                    [0,0,0]
                ],
                color: 'color-S'
            },
            { // T
                shape: [
                    [0,1,0],
                    [1,1,1],
                    [0,0,0]
                ],
                color: 'color-T'
            },
            { // Z
                shape: [
                    [1,1,0],
                    [0,1,1],
                    [0,0,0]
                ],
                color: 'color-Z'
            }
        ];

        // Initialize game board
        function initBoard() {
            board = Array(boardHeight).fill().map(() => Array(boardWidth).fill(0));
            const gameBoard = document.getElementById('gameBoard');
            gameBoard.innerHTML = '';
            
            for (let y = 0; y < boardHeight; y++) {
                for (let x = 0; x < boardWidth; x++) {
                    const cell = document.createElement('div');
                    cell.id = `cell-${y}-${x}`;
                    gameBoard.appendChild(cell);
                }
            }
        }

        // Get random tetromino
        function getRandomTetromino() {
            const index = Math.floor(Math.random() * tetrominos.length);
            return {
                shape: tetrominos[index].shape,
                color: tetrominos[index].color,
                x: Math.floor(boardWidth / 2) - Math.floor(tetrominos[index].shape[0].length / 2),
                y: 0
            };
        }

        // Draw game board
        function drawBoard() {
            for (let y = 0; y < boardHeight; y++) {
                for (let x = 0; x < boardWidth; x++) {
                    const cell = document.getElementById(`cell-${y}-${x}`);
                    cell.className = '';
                    if (board[y][x]) {
                        cell.classList.add('filled', board[y][x]);
                    }
                }
            }
            
            // Draw current piece
            if (currentPiece) {
                for (let y = 0; y < currentPiece.shape.length; y++) {
                    for (let x = 0; x < currentPiece.shape[y].length; x++) {
                        if (currentPiece.shape[y][x]) {
                            const boardY = currentPiece.y + y;
                            const boardX = currentPiece.x + x;
                            if (boardY >= 0) {
                                const cell = document.getElementById(`cell-${boardY}-${boardX}`);
                                if (cell) {
                                    cell.classList.add('filled', currentPiece.color);
                                }
                            }
                        }
                    }
                }
            }
        }

        // Draw next piece preview
        function drawNextPiece() {
            const nextPieceDiv = document.getElementById('nextPiece');
            nextPieceDiv.innerHTML = '';
            
            if (!nextPiece) return;
            
            const preview = document.createElement('div');
            preview.style.display = 'grid';
            preview.style.gridTemplateColumns = `repeat(${nextPiece.shape[0].length}, 25px)`;
            preview.style.gap = '2px';
            preview.style.justifyContent = 'center';
            
            for (let y = 0; y < nextPiece.shape.length; y++) {
                for (let x = 0; x < nextPiece.shape[y].length; x++) {
                    const cell = document.createElement('div');
                    cell.style.width = '25px';
                    cell.style.height = '25px';
                    cell.style.borderRadius = '3px';
                    if (nextPiece.shape[y][x]) {
                        cell.classList.add('filled', nextPiece.color);
                    } else {
                        cell.style.backgroundColor = 'rgba(255,255,255,0.1)';
                    }
                    preview.appendChild(cell);
                }
            }
            
            nextPieceDiv.appendChild(preview);
        }

        // Check collision
        function checkCollision(piece, xOffset = 0, yOffset = 0) {
            for (let y = 0; y < piece.shape.length; y++) {
                for (let x = 0; x < piece.shape[y].length; x++) {
                    if (piece.shape[y][x]) {
                        const newX = piece.x + x + xOffset;
                        const newY = piece.y + y + yOffset;
                        
                        if (newX < 0 || newX >= boardWidth || newY >= boardHeight) {
                            return true;
                        }
                        
                        if (newY >= 0 && board[newY][newX]) {
                            return true;
                        }
                    }
                }
            }
            return false;
        }

        // Merge piece to board
        function mergePiece() {
            for (let y = 0; y < currentPiece.shape.length; y++) {
                for (let x = 0; x < currentPiece.shape[y].length; x++) {
                    if (currentPiece.shape[y][x]) {
                        const boardY = currentPiece.y + y;
                        const boardX = currentPiece.x + x;
                        if (boardY >= 0) {
                            board[boardY][boardX] = currentPiece.color;
                        }
                    }
                }
            }
        }

        // Clear completed lines
        function clearLines() {
            let linesCleared = 0;
            
            for (let y = boardHeight - 1; y >= 0; y--) {
                if (board[y].every(cell => cell !== 0)) {
                    board.splice(y, 1);
                    board.unshift(Array(boardWidth).fill(0));
                    linesCleared++;
                    y++; // Check same line again after shift
                }
            }
            
            if (linesCleared > 0) {
                // Update score
                const linePoints = [40, 100, 300, 1200];
                score += linePoints[linesCleared - 1] * level;
                lines += linesCleared;
                level = Math.floor(lines / 10) + 1;
                dropSpeed = Math.max(100, 1000 - (level - 1) * 100);
                
                updateStats();
            }
        }

        // Update game stats display
        function updateStats() {
            document.getElementById('score').textContent = score.toLocaleString();
            document.getElementById('level').textContent = level;
            document.getElementById('lines').textContent = lines;
        }

        // Spawn new piece
        function spawnPiece() {
            currentPiece = nextPiece || getRandomTetromino();
            nextPiece = getRandomTetromino();
            
            if (checkCollision(currentPiece)) {
                gameOver();
                return false;
            }
            
            drawNextPiece();
            return true;
        }

        // Move piece
        function movePiece(xOffset, yOffset) {
            if (!checkCollision(currentPiece, xOffset, yOffset)) {
                currentPiece.x += xOffset;
                currentPiece.y += yOffset;
                return true;
            }
            return false;
        }

        // Rotate piece
        function rotatePiece() {
            const originalShape = currentPiece.shape;
            // Transpose matrix
            const rotated = originalShape[0].map((_, index) =>
                originalShape.map(row => row[index]).reverse()
            );
            
            const originalShapeBackup = currentPiece.shape;
            currentPiece.shape = rotated;
            
            if (checkCollision(currentPiece)) {
                currentPiece.shape = originalShapeBackup;
                return false;
            }
            
            return true;
        }

        // Hard drop
        function hardDrop() {
            while (movePiece(0, 1)) {}
            placePiece();
        }

        // Place piece
        function placePiece() {
            mergePiece();
            clearLines();
            if (!spawnPiece()) {
                return;
            }
        }

        // Game loop
        function gameUpdate(currentTime) {
            if (!gameRunning) return;
            
            if (currentTime - lastDropTime > dropSpeed) {
                if (!movePiece(0, 1)) {
                    placePiece();
                }
                lastDropTime = currentTime;
            }
            
            drawBoard();
            requestAnimationFrame(gameUpdate);
        }

        // Start game
        function startGame() {
            if (gameRunning) return;
            
            initBoard();
            score = 0;
            level = 1;
            lines = 0;
            dropSpeed = 1000;
            updateStats();
            
            nextPiece = getRandomTetromino();
            spawnPiece();
            
            gameRunning = true;
            lastDropTime = performance.now();
            gameLoop = requestAnimationFrame(gameUpdate);
            
            document.getElementById('gameOverModal').style.display = 'none';
        }

        // Pause game
        function pauseGame() {
            if (!gameRunning) return;
            
            gameRunning = false;
            cancelAnimationFrame(gameLoop);
        }

        // Restart game
        function restartGame() {
            pauseGame();
            startGame();
        }

        // Game over
        function gameOver() {
            gameRunning = false;
            cancelAnimationFrame(gameLoop);
            
            document.getElementById('finalScore').textContent = score.toLocaleString();
            document.getElementById('gameOverModal').style.display = 'flex';
        }

        // Save score
        async function saveScore() {
            const playerName = document.getElementById('playerName').value.trim();
            if (!playerName) {
                alert('Please enter your name');
                return;
            }
            
            try {
                const response = await fetch('/save-score', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        player_name: playerName,
                        score: score,
                        level: level,
                        lines_cleared: lines
                    })
                });
                
                if (response.ok) {
                    alert('Score saved successfully!');
                    updateHighScores();
                    restartGame();
                }
            } catch (error) {
                console.error('Error saving score:', error);
                alert('Error saving score. Please try again.');
            }
        }

        // Update high scores display
        async function updateHighScores() {
            try {
                const response = await fetch('/high-scores');
                const scores = await response.json();
                
                const scoresList = document.getElementById('highScoresList');
                scoresList.innerHTML = '';
                
                scores.forEach((score, index) => {
                    const scoreItem = document.createElement('div');
                    scoreItem.className = 'score-item';
                    scoreItem.innerHTML = `
                        <div class="score-rank">#${index + 1}</div>
                        <div class="score-player">${score.player_name}</div>
                        <div class="score-value">${parseInt(score.score).toLocaleString()}</div>
                    `;
                    scoresList.appendChild(scoreItem);
                });
            } catch (error) {
                console.error('Error loading high scores:', error);
            }
        }

        // Keyboard controls
        document.addEventListener('keydown', (e) => {
            if (!gameRunning) return;
            
            switch(e.key) {
                case 'ArrowLeft':
                    movePiece(-1, 0);
                    break;
                case 'ArrowRight':
                    movePiece(1, 0);
                    break;
                case 'ArrowDown':
                    movePiece(0, 1);
                    break;
                case 'ArrowUp':
                    rotatePiece();
                    break;
                case ' ':
                    hardDrop();
                    e.preventDefault();
                    break;
                case 'p':
                case 'P':
                    pauseGame();
                    break;
            }
        });

        // Initialize game
        window.onload = function() {
            initBoard();
            updateHighScores();
        };
    </script>
</body>
</html>