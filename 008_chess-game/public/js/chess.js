import './bootstrap';

class ChessGame {
    constructor() {
        this.selectedSquare = null;
        this.validMoves = [];
        this.gameId = gameId;
        this.currentTurn = currentTurn;
        this.init();
    }

    init() {
        this.addBoardListeners();
        this.updateTurnIndicator();
    }

    addBoardListeners() {
        document.querySelectorAll('.chess-square').forEach(square => {
            square.addEventListener('click', () => this.handleSquareClick(square));
        });
    }

    async handleSquareClick(square) {
        const row = parseInt(square.dataset.row);
        const col = parseInt(square.dataset.col);
        
        if (this.selectedSquare) {
            const fromRow = parseInt(this.selectedSquare.dataset.row);
            const fromCol = parseInt(this.selectedSquare.dataset.col);
            
            // Check if this is a valid move
            const isValidMove = this.validMoves.some(([r, c]) => r === row && c === col);
            
            if (isValidMove) {
                await this.makeMove(fromRow, fromCol, row, col);
                this.clearSelection();
            } else {
                // Select a different piece
                this.selectPiece(row, col);
            }
        } else {
            this.selectPiece(row, col);
        }
    }

    async selectPiece(row, col) {
        this.clearSelection();
        
        // Get valid moves for this piece
        try {
            const response = await fetch(`/chess/game/${this.gameId}/valid-moves?row=${row}&col=${col}`);
            this.validMoves = await response.json();
            
            if (this.validMoves.length > 0) {
                this.selectedSquare = document.querySelector(`.square-${row}-${col}`);
                this.selectedSquare.classList.add('selected');
                
                // Highlight valid moves
                this.validMoves.forEach(([r, c]) => {
                    const moveSquare = document.querySelector(`.square-${r}-${c}`);
                    if (moveSquare) {
                        const piece = moveSquare.querySelector('.chess-piece');
                        moveSquare.classList.add(piece ? 'valid-capture' : 'valid-move');
                    }
                });
            }
        } catch (error) {
            console.error('Error fetching valid moves:', error);
        }
    }

    async makeMove(fromRow, fromCol, toRow, toCol) {
        try {
            const response = await fetch(`/chess/game/${this.gameId}/move`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    from_row: fromRow,
                    from_col: fromCol,
                    to_row: toRow,
                    to_col: toCol
                })
            });

            const result = await response.json();
            
            // Update the board
            this.updateBoard(result.board);
            this.updateMovesList(result.moves);
            this.updateTurn(result.turn);
            
            if (result.status === 'completed') {
                this.showGameOver(result.winner);
            }
        } catch (error) {
            console.error('Error making move:', error);
            alert('Error making move. Please try again.');
        }
    }

    updateBoard(board) {
        board.forEach((row, rowIndex) => {
            row.forEach((piece, colIndex) => {
                const square = document.querySelector(`.square-${rowIndex}-${colIndex}`);
                if (square) {
                    const pieceElement = square.querySelector('.chess-piece');
                    if (piece) {
                        if (pieceElement) {
                            pieceElement.textContent = this.getPieceSymbol(piece);
                            pieceElement.className = `chess-piece ${piece === piece.toLowerCase() ? 'black-piece' : 'white-piece'}`;
                        } else {
                            square.innerHTML = `<span class="chess-piece ${piece === piece.toLowerCase() ? 'black-piece' : 'white-piece'}">${this.getPieceSymbol(piece)}</span>`;
                        }
                    } else {
                        square.innerHTML = '';
                    }
                }
            });
        });
    }

    updateMovesList(moves) {
        const movesList = document.getElementById('moves-list');
        movesList.innerHTML = '';
        
        moves.forEach((move, index) => {
            const moveItem = document.createElement('div');
            moveItem.className = 'move-item';
            moveItem.innerHTML = `
                <span class="move-number">${index + 1}.</span>
                <span class="move-notation">${move}</span>
            `;
            movesList.appendChild(moveItem);
        });
        
        // Scroll to bottom
        movesList.scrollTop = movesList.scrollHeight;
    }

    updateTurn(turn) {
        this.currentTurn = turn;
        this.updateTurnIndicator();
    }

    updateTurnIndicator() {
        const indicator = document.querySelector('.badge');
        if (indicator) {
            indicator.className = `badge bg-${this.currentTurn === 'white' ? 'light' : 'dark'} text-${this.currentTurn === 'white' ? 'dark' : 'light'} p-2`;
            indicator.textContent = `Turn: ${this.currentTurn.charAt(0).toUpperCase() + this.currentTurn.slice(1)}`;
        }
    }

    showGameOver(winner) {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-success mt-3';
        alertDiv.innerHTML = `
            <h4><i class="bi bi-trophy"></i> Game Over!</h4>
            <p class="mb-0">Winner: ${winner.charAt(0).toUpperCase() + winner.slice(1)}</p>
        `;
        
        const gameContainer = document.querySelector('.chess-container');
        gameContainer.querySelector('.col-md-4').appendChild(alertDiv);
    }

    clearSelection() {
        if (this.selectedSquare) {
            this.selectedSquare.classList.remove('selected');
            this.selectedSquare = null;
        }
        
        // Clear valid move highlights
        document.querySelectorAll('.chess-square').forEach(square => {
            square.classList.remove('valid-move', 'valid-capture');
        });
        
        this.validMoves = [];
    }

    getPieceSymbol(piece) {
        const symbols = {
            'p': '♟', 'r': '♜', 'n': '♞', 'b': '♝', 'q': '♛', 'k': '♚',
            'P': '♙', 'R': '♖', 'N': '♘', 'B': '♗', 'Q': '♕', 'K': '♔'
        };
        return symbols[piece] || '';
    }
}

// Initialize the game when page loads
document.addEventListener('DOMContentLoaded', () => {
    window.chessGame = new ChessGame();
});