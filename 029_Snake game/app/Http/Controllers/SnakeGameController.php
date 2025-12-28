<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SnakeGameController extends Controller
{
    public function index()
    {
        try {
            // Check if scores table exists
            if (DB::getSchemaBuilder()->hasTable('scores')) {
                $highScores = Score::orderBy('score', 'desc')
                    ->take(10)
                    ->get();
            } else {
                $highScores = collect();
            }
        } catch (\Exception $e) {
            $highScores = collect();
        }
            
        return view('game', compact('highScores'));
    }

    public function saveScore(Request $request)
    {
        $request->validate([
            'player_name' => 'required|string|max:50',
            'score' => 'required|integer|min:0',
            'level' => 'required|integer|min:1',
            'snake_length' => 'required|integer|min:3',
        ]);

        try {
            Score::create($request->all());
            return response()->json(['success' => true, 'message' => 'Score saved successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to save score'], 500);
        }
    }

    public function getHighScores()
    {
        try {
            if (DB::getSchemaBuilder()->hasTable('scores')) {
                $scores = Score::orderBy('score', 'desc')
                    ->take(10)
                    ->get()
                    ->map(function ($score) {
                        return [
                            'player_name' => $score->player_name,
                            'score' => $score->score,
                            'level' => $score->level,
                            'date' => $score->created_at->format('M d, Y'),
                        ];
                    });
            } else {
                $scores = [];
            }

            return response()->json($scores);
        } catch (\Exception $e) {
            return response()->json([]);
        }
    }
}