<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;

class TetrisController extends Controller
{
    public function index()
    {
        $highScores = Score::orderBy('score', 'desc')
            ->take(10)
            ->get();
        
        return view('tetris.index', compact('highScores'));
    }

    public function saveScore(Request $request)
    {
        $validated = $request->validate([
            'player_name' => 'required|string|max:50',
            'score' => 'required|integer',
            'level' => 'required|integer',
            'lines_cleared' => 'required|integer',
        ]);

        Score::create($validated);

        return response()->json(['message' => 'Score saved successfully']);
    }

    public function getHighScores()
    {
        $scores = Score::orderBy('score', 'desc')
            ->take(10)
            ->get();

        return response()->json($scores);
    }
}