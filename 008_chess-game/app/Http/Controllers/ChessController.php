<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Services\ChessService;
use Illuminate\Http\Request;

class ChessController extends Controller
{
    protected $chessService;

    public function __construct(ChessService $chessService)
    {
        $this->chessService = $chessService;
    }

    public function index()
    {
        $games = Game::where('status', '!=', 'completed')
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        return view('chess.index', compact('games'));
    }

    public function create()
    {
        $game = Game::create([
            'board_state' => (new Game())->initializeBoard(),
            'player_white' => 'Player ' . rand(1000, 9999),
            'status' => 'ongoing'
        ]);

        return redirect()->route('chess.game', $game->id);
    }

    public function game($id)
    {
        $game = Game::findOrFail($id);
        return view('chess.game', compact('game'));
    }

    public function move(Request $request, $id)
    {
        $game = Game::findOrFail($id);
        $boardState = $game->board_state;

        $fromRow = $request->input('from_row');
        $fromCol = $request->input('from_col');
        $toRow = $request->input('to_row');
        $toCol = $request->input('to_col');

        $piece = $boardState['board'][$fromRow][$fromCol];

        // Move the piece
        $boardState['board'][$toRow][$toCol] = $piece;
        $boardState['board'][$fromRow][$fromCol] = '';

        // Switch turn
        $boardState['turn'] = $boardState['turn'] === 'white' ? 'black' : 'white';

        // Add to moves history
        $moveNotation = $this->getMoveNotation($piece, $fromRow, $fromCol, $toRow, $toCol);
        $boardState['moves'][] = $moveNotation;

        // Check for checkmate (simplified)
        if ($this->isKingCaptured($boardState['board'])) {
            $boardState['status'] = 'completed';
            $boardState['winner'] = $boardState['turn'] === 'white' ? 'black' : 'white';
            $game->status = 'completed';
            $game->winner = $boardState['winner'];
        }

        $game->board_state = $boardState;
        $game->save();

        return response()->json($boardState);
    }

    public function getValidMoves(Request $request, $id)
    {
        $game = Game::findOrFail($id);
        $boardState = $game->board_state;

        $row = $request->input('row');
        $col = $request->input('col');
        $piece = $boardState['board'][$row][$col];

        if (!$piece) {
            return response()->json([]);
        }

        $validMoves = $this->chessService->getValidMoves(
            $boardState['board'],
            $row,
            $col,
            $piece
        );

        return response()->json($validMoves);
    }

    private function getMoveNotation($piece, $fromRow, $fromCol, $toRow, $toCol): string
    {
        $columns = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];
        $pieceSymbol = strtoupper($piece) === 'P' ? '' : strtoupper($piece);
        
        return sprintf(
            '%s%s%d -> %s%d',
            $pieceSymbol,
            $columns[$fromCol],
            8 - $fromRow,
            $columns[$toCol],
            8 - $toRow
        );
    }

    private function isKingCaptured($board): bool
    {
        $hasWhiteKing = false;
        $hasBlackKing = false;

        foreach ($board as $row) {
            foreach ($row as $piece) {
                if ($piece === 'K') $hasWhiteKing = true;
                if ($piece === 'k') $hasBlackKing = true;
            }
        }

        return !$hasWhiteKing || !$hasBlackKing;
    }
}