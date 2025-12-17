<?php

namespace App\Http\Controllers;

use App\Models\GameScore;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        return view('game.index');
    }

    public function play()
    {
        return view('game.play');
    }

    public function saveScore(Request $request)
    {
        $request->validate([
            'player_name' => 'required|string|max:50',
            'score' => 'required|integer',
            'level' => 'required|integer',
            'lives' => 'required|integer',
        ]);

        GameScore::create($request->all());

        return response()->json(['success' => true]);
    }

    public function highScores()
    {
        $scores = GameScore::orderBy('score', 'desc')
            ->take(10)
            ->get();

        return view('game.scores', compact('scores'));
    }
}