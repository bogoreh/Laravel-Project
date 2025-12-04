<?php

namespace App\Services;

class ChessService
{
    private const PIECES = [
        'p' => ['name' => 'pawn', 'color' => 'black'],
        'r' => ['name' => 'rook', 'color' => 'black'],
        'n' => ['name' => 'knight', 'color' => 'black'],
        'b' => ['name' => 'bishop', 'color' => 'black'],
        'q' => ['name' => 'queen', 'color' => 'black'],
        'k' => ['name' => 'king', 'color' => 'black'],
        'P' => ['name' => 'pawn', 'color' => 'white'],
        'R' => ['name' => 'rook', 'color' => 'white'],
        'N' => ['name' => 'knight', 'color' => 'white'],
        'B' => ['name' => 'bishop', 'color' => 'white'],
        'Q' => ['name' => 'queen', 'color' => 'white'],
        'K' => ['name' => 'king', 'color' => 'white'],
    ];

    public function getPieceInfo(string $piece): array
    {
        return self::PIECES[$piece] ?? ['name' => '', 'color' => ''];
    }

    public function getValidMoves(array $board, int $row, int $col, string $piece): array
    {
        $piece = strtolower($piece);
        $moves = [];

        switch ($piece) {
            case 'p': // Pawn
                $direction = ($board[$row][$col] === 'P') ? -1 : 1;
                // Move forward
                if ($this->isEmpty($board, $row + $direction, $col)) {
                    $moves[] = [$row + $direction, $col];
                    // First move two squares
                    if (($row === 1 && $direction === 1) || ($row === 6 && $direction === -1)) {
                        if ($this->isEmpty($board, $row + 2 * $direction, $col)) {
                            $moves[] = [$row + 2 * $direction, $col];
                        }
                    }
                }
                // Captures
                foreach ([-1, 1] as $dx) {
                    $newCol = $col + $dx;
                    if ($newCol >= 0 && $newCol < 8) {
                        $target = $board[$row + $direction][$newCol] ?? '';
                        if ($target && $this->isOpponent($board[$row][$col], $target)) {
                            $moves[] = [$row + $direction, $newCol];
                        }
                    }
                }
                break;

            case 'r': // Rook
                $moves = $this->getLinearMoves($board, $row, $col, [[1,0],[-1,0],[0,1],[0,-1]]);
                break;

            case 'n': // Knight
                $knightMoves = [[2,1],[2,-1],[-2,1],[-2,-1],[1,2],[1,-2],[-1,2],[-1,-2]];
                foreach ($knightMoves as [$dx, $dy]) {
                    $newRow = $row + $dx;
                    $newCol = $col + $dy;
                    if ($this->isValidPosition($newRow, $newCol)) {
                        $target = $board[$newRow][$newCol] ?? '';
                        if (!$target || $this->isOpponent($board[$row][$col], $target)) {
                            $moves[] = [$newRow, $newCol];
                        }
                    }
                }
                break;

            case 'b': // Bishop
                $moves = $this->getLinearMoves($board, $row, $col, [[1,1],[1,-1],[-1,1],[-1,-1]]);
                break;

            case 'q': // Queen
                $moves = $this->getLinearMoves($board, $row, $col, 
                    [[1,0],[-1,0],[0,1],[0,-1],[1,1],[1,-1],[-1,1],[-1,-1]]);
                break;

            case 'k': // King
                $kingMoves = [[1,0],[-1,0],[0,1],[0,-1],[1,1],[1,-1],[-1,1],[-1,-1]];
                foreach ($kingMoves as [$dx, $dy]) {
                    $newRow = $row + $dx;
                    $newCol = $col + $dy;
                    if ($this->isValidPosition($newRow, $newCol)) {
                        $target = $board[$newRow][$newCol] ?? '';
                        if (!$target || $this->isOpponent($board[$row][$col], $target)) {
                            $moves[] = [$newRow, $newCol];
                        }
                    }
                }
                break;
        }

        return $moves;
    }

    private function getLinearMoves(array $board, int $row, int $col, array $directions): array
    {
        $moves = [];
        $pieceColor = ctype_lower($board[$row][$col]) ? 'black' : 'white';

        foreach ($directions as [$dx, $dy]) {
            $newRow = $row + $dx;
            $newCol = $col + $dy;

            while ($this->isValidPosition($newRow, $newCol)) {
                $target = $board[$newRow][$newCol] ?? '';
                
                if (!$target) {
                    $moves[] = [$newRow, $newCol];
                } else {
                    $targetColor = ctype_lower($target) ? 'black' : 'white';
                    if ($pieceColor !== $targetColor) {
                        $moves[] = [$newRow, $newCol];
                    }
                    break;
                }
                
                $newRow += $dx;
                $newCol += $dy;
            }
        }

        return $moves;
    }

    private function isEmpty(array $board, int $row, int $col): bool
    {
        return $this->isValidPosition($row, $col) && empty($board[$row][$col]);
    }

    private function isOpponent(string $piece1, string $piece2): bool
    {
        return (ctype_lower($piece1) && ctype_upper($piece2)) ||
               (ctype_upper($piece1) && ctype_lower($piece2));
    }

    private function isValidPosition(int $row, int $col): bool
    {
        return $row >= 0 && $row < 8 && $col >= 0 && $col < 8;
    }
}