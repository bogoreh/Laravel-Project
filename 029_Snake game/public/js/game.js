class SnakeGame {
    constructor() {
        this.canvas = document.getElementById('gameCanvas');
        this.ctx = this.canvas.getContext('2d');
        this.gridSize = 20;
        this.tileCount = this.canvas.width / this.gridSize;
        
        this.snake = [];
        this.snakeLength = 3;
        this.snakeX = 10;
        this.snakeY = 10;
        this.velocityX = 0;
        this.velocityY = 0;
        
        this.foodX = 5;
        this.foodY = 5;
        
        this.score = 0;
        this.level = 1;
        this.highScore = parseInt(document.getElementById('high-score').textContent);
        
        this.gameSpeed = 10;
        this.gameRunning = false;
        this.gamePaused = false;
        
        this.keys = {};
        this.setupEventListeners();
        this.draw();
    }

    setupEventListeners() {
        // Keyboard controls
        document.addEventListener('keydown', (e) => {
            this.keys[e.key] = true;
            
            if (e.key === ' ' || e.key === 'Spacebar') {
                e.preventDefault();
                this.togglePause();
            }
            
            if (!this.gameRunning || this.gamePaused) return;
            
            if ((e.key === 'ArrowUp' || e.key === 'w' || e.key === 'W') && this.velocityY !== 1) {
                this.velocityX = 0;
                this.velocityY = -1;
            } else if ((e.key === 'ArrowDown' || e.key === 's' || e.key === 'S') && this.velocityY !== -1) {
                this.velocityX = 0;
                this.velocityY = 1;
            } else if ((e.key === 'ArrowLeft' || e.key === 'a' || e.key === 'A') && this.velocityX !== 1) {
                this.velocityX = -1;
                this.velocityY = 0;
            } else if ((e.key === 'ArrowRight' || e.key === 'd' || e.key === 'D') && this.velocityX !== -1) {
                this.velocityX = 1;
                this.velocityY = 0;
            }
        });

        document.addEventListener('keyup', (e) => {
            this.keys[e.key] = false;
        });

        // Button controls
        document.getElementById('start-btn').addEventListener('click', () => this.startGame());
        document.getElementById('pause-btn').addEventListener('click', () => this.togglePause());
        document.getElementById('restart-btn').addEventListener('click', () => this.resetGame());
        document.getElementById('save-score-btn').addEventListener('click', () => this.saveScore());
        document.getElementById('refresh-scores').addEventListener('click', () => this.loadHighScores());
        
        // Mobile swipe controls
        let touchStartX = 0;
        let touchStartY = 0;
        
        this.canvas.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
            touchStartY = e.changedTouches[0].screenY;
            e.preventDefault();
        }, { passive: false });
        
        this.canvas.addEventListener('touchend', (e) => {
            if (!this.gameRunning || this.gamePaused) return;
            
            const touchEndX = e.changedTouches[0].screenX;
            const touchEndY = e.changedTouches[0].screenY;
            
            const dx = touchEndX - touchStartX;
            const dy = touchEndY - touchStartY;
            
            if (Math.abs(dx) > Math.abs(dy)) {
                // Horizontal swipe
                if (dx > 0 && this.velocityX !== -1) {
                    this.velocityX = 1;
                    this.velocityY = 0;
                } else if (dx < 0 && this.velocityX !== 1) {
                    this.velocityX = -1;
                    this.velocityY = 0;
                }
            } else {
                // Vertical swipe
                if (dy > 0 && this.velocityY !== -1) {
                    this.velocityX = 0;
                    this.velocityY = 1;
                } else if (dy < 0 && this.velocityY !== 1) {
                    this.velocityX = 0;
                    this.velocityY = -1;
                }
            }
            e.preventDefault();
        }, { passive: false });
    }

    startGame() {
        if (!this.gameRunning) {
            this.gameRunning = true;
            this.gamePaused = false;
            document.getElementById('start-btn').disabled = true;
            document.getElementById('pause-btn').disabled = false;
            document.getElementById('game-over').style.display = 'none';
            this.gameLoop();
        }
    }

    togglePause() {
        if (!this.gameRunning) return;
        
        this.gamePaused = !this.gamePaused;
        const pauseBtn = document.getElementById('pause-btn');
        const icon = pauseBtn.querySelector('i');
        
        if (this.gamePaused) {
            pauseBtn.innerHTML = '<i class="fas fa-play"></i> Resume';
            pauseBtn.classList.remove('btn-secondary');
            pauseBtn.classList.add('btn-success');
        } else {
            pauseBtn.innerHTML = '<i class="fas fa-pause"></i> Pause';
            pauseBtn.classList.remove('btn-success');
            pauseBtn.classList.add('btn-secondary');
            this.gameLoop();
        }
    }

    resetGame() {
        this.snake = [];
        this.snakeLength = 3;
        this.snakeX = 10;
        this.snakeY = 10;
        this.velocityX = 0;
        this.velocityY = 0;
        this.score = 0;
        this.level = 1;
        this.gameSpeed = 10;
        
        document.getElementById('score').textContent = '0';
        document.getElementById('level').textContent = '1';
        document.getElementById('length').textContent = '3';
        document.getElementById('start-btn').disabled = false;
        document.getElementById('pause-btn').disabled = true;
        document.getElementById('game-over').style.display = 'none';
        
        this.gameRunning = false;
        this.gamePaused = false;
        
        this.placeFood();
        this.draw();
    }

    gameLoop() {
        if (!this.gameRunning || this.gamePaused) return;
        
        this.update();
        this.draw();
        
        setTimeout(() => this.gameLoop(), 1000 / this.gameSpeed);
    }

    update() {
        // Move snake
        this.snakeX += this.velocityX;
        this.snakeY += this.velocityY;
        
        // Wrap around edges
        if (this.snakeX < 0) this.snakeX = this.tileCount - 1;
        if (this.snakeX >= this.tileCount) this.snakeX = 0;
        if (this.snakeY < 0) this.snakeY = this.tileCount - 1;
        if (this.snakeY >= this.tileCount) this.snakeY = 0;
        
        // Check collision with self
        for (let segment of this.snake) {
            if (segment.x === this.snakeX && segment.y === this.snakeY) {
                this.gameOver();
                return;
            }
        }
        
        // Add new head
        this.snake.push({x: this.snakeX, y: this.snakeY});
        
        // Remove tail if snake is too long
        while (this.snake.length > this.snakeLength) {
            this.snake.shift();
        }
        
        // Check food collision
        if (this.snakeX === this.foodX && this.snakeY === this.foodY) {
            this.snakeLength++;
            this.score += 10 * this.level;
            
            // Level up every 100 points
            if (this.score >= this.level * 100) {
                this.level++;
                this.gameSpeed += 2; // Increase speed with level
            }
            
            this.placeFood();
            this.updateDisplay();
        }
    }

    draw() {
        // Clear canvas
        this.ctx.fillStyle = '#0d1525';
        this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);
        
        // Draw grid
        this.ctx.strokeStyle = 'rgba(255, 255, 255, 0.05)';
        this.ctx.lineWidth = 1;
        
        for (let x = 0; x < this.tileCount; x++) {
            for (let y = 0; y < this.tileCount; y++) {
                this.ctx.strokeRect(x * this.gridSize, y * this.gridSize, this.gridSize, this.gridSize);
            }
        }
        
        // Draw snake
        this.snake.forEach((segment, index) => {
            const gradient = this.ctx.createLinearGradient(
                segment.x * this.gridSize,
                segment.y * this.gridSize,
                (segment.x + 1) * this.gridSize,
                (segment.y + 1) * this.gridSize
            );
            
            if (index === this.snake.length - 1) {
                // Head
                gradient.addColorStop(0, '#00ff88');
                gradient.addColorStop(1, '#00cc6a');
            } else {
                // Body
                const intensity = 0.7 - (index / this.snake.length) * 0.4;
                gradient.addColorStop(0, `rgba(0, 255, 136, ${intensity})`);
                gradient.addColorStop(1, `rgba(0, 204, 106, ${intensity})`);
            }
            
            this.ctx.fillStyle = gradient;
            this.ctx.fillRect(segment.x * this.gridSize, segment.y * this.gridSize, this.gridSize - 2, this.gridSize - 2);
            
            // Snake eyes on head
            if (index === this.snake.length - 1) {
                this.ctx.fillStyle = '#000';
                const eyeSize = 4;
                const offset = 5;
                
                // Left eye
                this.ctx.fillRect(
                    segment.x * this.gridSize + offset,
                    segment.y * this.gridSize + offset,
                    eyeSize, eyeSize
                );
                
                // Right eye
                this.ctx.fillRect(
                    (segment.x + 1) * this.gridSize - offset - eyeSize,
                    segment.y * this.gridSize + offset,
                    eyeSize, eyeSize
                );
            }
        });
        
        // Draw food
        this.ctx.fillStyle = '#ff4757';
        this.ctx.beginPath();
        this.ctx.arc(
            this.foodX * this.gridSize + this.gridSize / 2,
            this.foodY * this.gridSize + this.gridSize / 2,
            this.gridSize / 2 - 2,
            0,
            Math.PI * 2
        );
        this.ctx.fill();
        
        // Draw food glow
        this.ctx.shadowColor = '#ff4757';
        this.ctx.shadowBlur = 15;
        this.ctx.fill();
        this.ctx.shadowBlur = 0;
        
        // Draw score on canvas if game is running
        if (this.gameRunning && !this.gamePaused) {
            this.ctx.fillStyle = 'rgba(255, 255, 255, 0.7)';
            this.ctx.font = '16px "Press Start 2P"';
            this.ctx.fillText(`SCORE: ${this.score}`, 10, 25);
            this.ctx.fillText(`LEVEL: ${this.level}`, 10, 50);
        }
        
        // Draw pause message
        if (this.gamePaused) {
            this.ctx.fillStyle = 'rgba(0, 0, 0, 0.8)';
            this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);
            
            this.ctx.fillStyle = '#fff';
            this.ctx.font = '30px "Press Start 2P"';
            this.ctx.textAlign = 'center';
            this.ctx.fillText('PAUSED', this.canvas.width / 2, this.canvas.height / 2);
            this.ctx.font = '16px "Press Start 2P"';
            this.ctx.fillText('Press SPACE to resume', this.canvas.width / 2, this.canvas.height / 2 + 40);
            this.ctx.textAlign = 'start';
        }
    }

    placeFood() {
        let validPosition = false;
        
        while (!validPosition) {
            this.foodX = Math.floor(Math.random() * this.tileCount);
            this.foodY = Math.floor(Math.random() * this.tileCount);
            
            validPosition = true;
            
            // Check if food overlaps with snake
            for (let segment of this.snake) {
                if (segment.x === this.foodX && segment.y === this.foodY) {
                    validPosition = false;
                    break;
                }
            }
        }
    }

    updateDisplay() {
        document.getElementById('score').textContent = this.score;
        document.getElementById('level').textContent = this.level;
        document.getElementById('length').textContent = this.snakeLength;
        
        if (this.score > this.highScore) {
            this.highScore = this.score;
            document.getElementById('high-score').textContent = this.highScore;
        }
    }

    gameOver() {
        this.gameRunning = false;
        document.getElementById('start-btn').disabled = false;
        document.getElementById('pause-btn').disabled = true;
        
        document.getElementById('final-score').textContent = this.score;
        document.getElementById('game-over').style.display = 'block';
        document.getElementById('player-name').value = '';
    }

    async saveScore() {
        const playerName = document.getElementById('player-name').value.trim();
        
        if (!playerName) {
            alert('Please enter your name to save your score!');
            return;
        }
        
        try {
            const response = await fetch('/save-score', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    player_name: playerName,
                    score: this.score,
                    level: this.level,
                    snake_length: this.snakeLength
                })
            });
            
            if (response.ok) {
                alert('Score saved successfully!');
                document.getElementById('game-over').style.display = 'none';
                this.loadHighScores();
            } else {
                alert('Failed to save score. Please try again.');
            }
        } catch (error) {
            console.error('Error saving score:', error);
            alert('Error saving score. Please check your connection.');
        }
    }

    async loadHighScores() {
        try {
            const response = await fetch('/high-scores');
            const scores = await response.json();
            
            const scoresList = document.getElementById('scores-list');
            scoresList.innerHTML = '';
            
            scores.forEach((score, index) => {
                const scoreRow = document.createElement('div');
                scoreRow.className = 'score-row';
                scoreRow.innerHTML = `
                    <span class="rank">#${index + 1}</span>
                    <span class="player">${score.player_name}</span>
                    <span class="points">${score.score}</span>
                    <span class="level">Level ${score.level}</span>
                `;
                scoresList.appendChild(scoreRow);
            });
            
            // Update high score display
            if (scores.length > 0) {
                this.highScore = scores[0].score;
                document.getElementById('high-score').textContent = this.highScore;
            }
        } catch (error) {
            console.error('Error loading high scores:', error);
        }
    }
}

// Initialize game when page loads
document.addEventListener('DOMContentLoaded', () => {
    window.snakeGame = new SnakeGame();
});