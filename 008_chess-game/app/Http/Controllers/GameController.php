<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function join($id, $color)
    {
        $game = Game::findOrFail($id);
        
        if ($color === 'white' && !$game->player_white) {
            $game->player_white = 'Player ' . rand(1000, 9999);
        } elseif ($color === 'black' && !$game->player_black) {
            $game->player_black = 'Player ' . rand(1000, 9999);
        }
        
        $game->save();
        
        return redirect()->route('chess.game', $id);
    }
}