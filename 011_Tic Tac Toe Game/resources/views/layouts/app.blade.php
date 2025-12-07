<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tic Tac Toe - Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
            --accent-color: #f59e0b;
            --dark-bg: #0f172a;
            --dark-card: #1e293b;
            --dark-card-hover: #334155;
            --dark-border: #475569;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
        }
        
        body {
            background: linear-gradient(135deg, var(--dark-bg) 0%, #1e293b 100%);
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            color: var(--text-primary);
        }
        
        .game-container {
            background: linear-gradient(145deg, var(--dark-card), #1a2234);
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5),
                        0 0 0 1px rgba(255, 255, 255, 0.05);
            padding: 40px;
            margin-top: 30px;
            border: 1px solid var(--dark-border);
            backdrop-filter: blur(10px);
        }
        
        .game-title {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            text-align: center;
            margin-bottom: 40px;
            font-size: 3rem;
            letter-spacing: -0.5px;
            position: relative;
        }
        
        .game-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 2px;
        }
        
        .status-card {
            background: linear-gradient(145deg, rgba(30, 41, 59, 0.8), rgba(15, 23, 42, 0.8));
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 40px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .status-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }
        
        .game-board {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 12px;
            max-width: 420px;
            margin: 0 auto;
            padding: 20px;
            background: rgba(15, 23, 42, 0.5);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .cell {
            aspect-ratio: 1;
            background: linear-gradient(145deg, #1e293b, #0f172a);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }
        
        .cell::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(145deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .cell:hover:not(.disabled) {
            transform: translateY(-4px);
            border-color: rgba(99, 102, 241, 0.3);
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.2),
                        0 0 20px rgba(139, 92, 246, 0.1);
        }
        
        .cell:hover:not(.disabled)::before {
            opacity: 1;
        }
        
        .cell.disabled {
            cursor: not-allowed;
            opacity: 0.8;
            transform: none !important;
        }
        
        .cell.x {
            color: #60a5fa;
            text-shadow: 0 0 30px rgba(96, 165, 250, 0.5);
        }
        
        .cell.o {
            color: #f472b6;
            text-shadow: 0 0 30px rgba(244, 114, 182, 0.5);
        }
        
        .controls {
            margin-top: 50px;
            text-align: center;
        }
        
        .btn-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            color: white;
            padding: 14px 36px;
            border-radius: 12px;
            font-weight: 600;
            margin: 10px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }
        
        .btn-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s;
        }
        
        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(99, 102, 241, 0.4);
            color: white;
        }
        
        .btn-custom:hover::before {
            left: 100%;
        }
        
        .btn-custom.reset {
            background: linear-gradient(135deg, #ef4444, #f87171);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
        }
        
        .btn-custom.reset:hover {
            box-shadow: 0 15px 35px rgba(239, 68, 68, 0.4);
        }
        
        .btn-custom:active {
            transform: translateY(-1px);
        }
        
        .game-mode-selector {
            background: rgba(15, 23, 42, 0.8);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
        }
        
        .mode-btn {
            flex: 1;
            padding: 16px;
            border: 2px solid transparent;
            border-radius: 12px;
            background: linear-gradient(145deg, #1e293b, #0f172a);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: var(--text-secondary);
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }
        
        .mode-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
        }
        
        .mode-btn span {
            position: relative;
            z-index: 2;
        }
        
        .mode-btn.active {
            border-color: var(--primary-color);
            color: var(--text-primary);
            box-shadow: 0 5px 20px rgba(99, 102, 241, 0.2);
        }
        
        .mode-btn.active::before {
            opacity: 0.1;
        }
        
        .mode-btn:hover:not(.active) {
            border-color: var(--dark-border);
            color: var(--text-primary);
            transform: translateY(-2px);
        }
        
        .winner-animation {
            animation: glow 2s infinite alternate;
            box-shadow: 0 0 40px rgba(16, 185, 129, 0.3) !important;
        }
        
        @keyframes glow {
            from {
                box-shadow: 0 0 20px rgba(16, 185, 129, 0.2),
                            inset 0 0 20px rgba(16, 185, 129, 0.1);
            }
            to {
                box-shadow: 0 0 40px rgba(16, 185, 129, 0.4),
                            inset 0 0 30px rgba(16, 185, 129, 0.2);
            }
        }
        
        .player-indicator {
            display: inline-flex;
            align-items: center;
            padding: 12px 28px;
            border-radius: 12px;
            background: linear-gradient(145deg, #1e293b, #0f172a);
            margin: 0 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
            min-width: 140px;
            justify-content: center;
        }
        
        .player-indicator.active {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
            transform: translateY(-2px);
            border-color: transparent;
        }
        
        .draw-animation {
            animation: drawGlow 2s infinite alternate;
        }
        
        @keyframes drawGlow {
            from {
                box-shadow: 0 0 20px rgba(245, 158, 11, 0.2);
            }
            to {
                box-shadow: 0 0 40px rgba(245, 158, 11, 0.4);
            }
        }
        
        .instructions {
            background: rgba(15, 23, 42, 0.6);
            border-radius: 16px;
            padding: 28px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            margin-top: 40px;
        }
        
        .instructions h5 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .instructions h5 i {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.2em;
        }
        
        .game-info {
            color: var(--text-secondary);
            font-size: 0.9rem;
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        @media (max-width: 768px) {
            .game-container {
                padding: 24px;
                margin: 15px;
            }
            
            .cell {
                font-size: 2.8rem;
            }
            
            .game-title {
                font-size: 2.2rem;
            }
            
            .player-indicator {
                min-width: 120px;
                padding: 10px 20px;
                font-size: 0.9rem;
            }
            
            .btn-custom {
                padding: 12px 28px;
                font-size: 0.9rem;
            }
        }
        
        /* Loading animation for computer move */
        .loading {
            position: relative;
        }
        
        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 30px;
            height: 30px;
            border: 3px solid rgba(255, 255, 255, 0.1);
            border-top-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to { transform: translate(-50%, -50%) rotate(360deg); }
        }
        
        /* Particle effect for winning cells */
        .winning-cell {
            animation: pulseWin 1.5s infinite;
        }
        
        @keyframes pulseWin {
            0% { transform: scale(1); box-shadow: 0 0 20px rgba(16, 185, 129, 0.3); }
            50% { transform: scale(1.05); box-shadow: 0 0 40px rgba(16, 185, 129, 0.6); }
            100% { transform: scale(1); box-shadow: 0 0 20px rgba(16, 185, 129, 0.3); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="game-container">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover preview for empty cells
            const cells = document.querySelectorAll('.cell:not(.disabled)');
            const currentPlayerElement = document.querySelector('.player-indicator.active');
            
            cells.forEach(cell => {
                cell.addEventListener('mouseenter', function() {
                    if (this.textContent.trim() === '' && !this.classList.contains('disabled')) {
                        const isXTurn = currentPlayerElement && currentPlayerElement.textContent.includes('X');
                        this.textContent = isXTurn ? 'X' : 'O';
                        this.style.opacity = '0.3';
                        this.style.color = isXTurn ? '#60a5fa' : '#f472b6';
                    }
                });
                
                cell.addEventListener('mouseleave', function() {
                    if (this.style.opacity === '0.3') {
                        this.textContent = '';
                        this.style.opacity = '1';
                        this.style.color = '';
                    }
                });
                
                // Add click animation
                cell.addEventListener('click', function() {
                    if (!this.classList.contains('disabled')) {
                        this.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            this.style.transform = '';
                        }, 150);
                    }
                });
            });
            
            // Add winning cell animation if there's a winner
            const winner = '{{ $winner ?? "" }}';
            if (winner && winner !== 'Draw') {
                setTimeout(() => {
                    const xCells = document.querySelectorAll('.cell.x');
                    const oCells = document.querySelectorAll('.cell.o');
                    const winningCells = winner === 'X' ? xCells : oCells;
                    
                    winningCells.forEach(cell => {
                        cell.classList.add('winning-cell');
                    });
                }, 500);
            }
            
            // Add loading animation for computer moves
            const gameMode = '{{ $gameMode ?? "pvp" }}';
            const currentPlayer = '{{ $currentPlayer ?? "X" }}';
            const gameOver = '{{ $gameOver ?? false }}';
            
            if (gameMode === 'pvc' && currentPlayer === 'O' && !gameOver) {
                // Show loading for computer move
                const board = document.querySelector('.game-board');
                board.classList.add('loading');
                
                // Remove loading after a short delay (simulating computer thinking)
                setTimeout(() => {
                    board.classList.remove('loading');
                }, 800);
            }
        });
        
        // Add sound effects (optional - commented out)
        /*
        function playSound(type) {
            const audio = new Audio();
            switch(type) {
                case 'click':
                    audio.src = '/sounds/click.mp3';
                    break;
                case 'win':
                    audio.src = '/sounds/win.mp3';
                    break;
                case 'draw':
                    audio.src = '/sounds/draw.mp3';
                    break;
            }
            audio.play();
        }
        */
    </script>
</body>
</html>