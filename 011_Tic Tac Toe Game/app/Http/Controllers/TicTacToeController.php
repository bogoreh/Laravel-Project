<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicTacToeController extends Controller
{
    private function initializeBoard()
    {
        return [
            ['', '', ''],
            ['', '', ''],
            ['', '', '']
        ];
    }

    private function checkWinner($board, $player)
    {
        // Check rows
        for ($i = 0; $i < 3; $i++) {
            if ($board[$i][0] === $player && $board[$i][1] === $player && $board[$i][2] === $player) {
                return true;
            }
        }

        // Check columns
        for ($i = 0; $i < 3; $i++) {
            if ($board[0][$i] === $player && $board[1][$i] === $player && $board[2][$i] === $player) {
                return true;
            }
        }

        // Check diagonals
        if ($board[0][0] === $player && $board[1][1] === $player && $board[2][2] === $player) {
            return true;
        }
        if ($board[0][2] === $player && $board[1][1] === $player && $board[2][0] === $player) {
            return true;
        }

        return false;
    }

    private function isBoardFull($board)
    {
        foreach ($board as $row) {
            foreach ($row as $cell) {
                if ($cell === '') {
                    return false;
                }
            }
        }
        return true;
    }

    private function makeComputerMove($board)
    {
        // Simple AI: find first empty cell
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($board[$i][$j] === '') {
                    return [$i, $j];
                }
            }
        }
        return null;
    }

    public function index(Request $request)
    {
        $board = $request->session()->get('board', $this->initializeBoard());
        $currentPlayer = $request->session()->get('currentPlayer', 'X');
        $winner = $request->session()->get('winner', null);
        $gameMode = $request->session()->get('gameMode', 'pvp'); // 'pvp' or 'pvc'
        $gameOver = $request->session()->get('gameOver', false);

        return view('tictactoe.index', compact('board', 'currentPlayer', 'winner', 'gameMode', 'gameOver'));
    }

    public function makeMove(Request $request)
    {
        $row = $request->input('row');
        $col = $request->input('col');
        
        $board = $request->session()->get('board', $this->initializeBoard());
        $currentPlayer = $request->session()->get('currentPlayer', 'X');
        $winner = $request->session()->get('winner', null);
        $gameMode = $request->session()->get('gameMode', 'pvp');
        $gameOver = $request->session()->get('gameOver', false);

        // If game is over or cell is already taken, do nothing
        if ($gameOver || $board[$row][$col] !== '') {
            return redirect()->route('tictactoe.index');
        }

        // Make player move
        $board[$row][$col] = $currentPlayer;

        // Check for winner
        if ($this->checkWinner($board, $currentPlayer)) {
            $winner = $currentPlayer;
            $gameOver = true;
        } elseif ($this->isBoardFull($board)) {
            $winner = 'Draw';
            $gameOver = true;
        } else {
            // Switch player
            $currentPlayer = $currentPlayer === 'X' ? 'O' : 'X';
            
            // If playing against computer and it's computer's turn
            if ($gameMode === 'pvc' && $currentPlayer === 'O' && !$gameOver) {
                $computerMove = $this->makeComputerMove($board);
                if ($computerMove) {
                    [$compRow, $compCol] = $computerMove;
                    $board[$compRow][$compCol] = 'O';
                    
                    // Check if computer won
                    if ($this->checkWinner($board, 'O')) {
                        $winner = 'O';
                        $gameOver = true;
                    } elseif ($this->isBoardFull($board)) {
                        $winner = 'Draw';
                        $gameOver = true;
                    } else {
                        $currentPlayer = 'X';
                    }
                }
            }
        }

        // Save game state to session
        $request->session()->put('board', $board);
        $request->session()->put('currentPlayer', $currentPlayer);
        $request->session()->put('winner', $winner);
        $request->session()->put('gameOver', $gameOver);

        return redirect()->route('tictactoe.index');
    }

    public function resetGame(Request $request)
    {
        $request->session()->forget(['board', 'currentPlayer', 'winner', 'gameOver']);
        $request->session()->put('board', $this->initializeBoard());
        $request->session()->put('currentPlayer', 'X');
        $request->session()->put('winner', null);
        $request->session()->put('gameOver', false);

        return redirect()->route('tictactoe.index');
    }

    public function changeMode(Request $request)
    {
        $mode = $request->input('mode');
        $request->session()->put('gameMode', $mode);
        
        // Reset game when changing mode
        return $this->resetGame($request);
    }
}