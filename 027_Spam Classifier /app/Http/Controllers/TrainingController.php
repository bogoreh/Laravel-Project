<?php

namespace App\Http\Controllers;

use App\Models\TrainingData;
use App\Services\ModelTrainerService;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index()
    {
        $trainingData = TrainingData::latest()->paginate(10);
        $stats = [
            'total' => TrainingData::count(),
            'spam' => TrainingData::spam()->count(),
            'ham' => TrainingData::ham()->count(),
        ];
        
        return view('spam.train', compact('trainingData', 'stats'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'label' => 'required|in:spam,ham',
        ]);
        
        TrainingData::create($request->only(['content', 'label']));
        
        return back()->with('success', 'Training sample added successfully!');
    }
    
    public function train(ModelTrainerService $trainer)
    {
        try {
            $result = $trainer->train();
            
            return back()->with('success', 
                "Model trained successfully! Accuracy: " . 
                number_format($result['accuracy'] * 100, 2) . "%"
            );
        } catch (\Exception $e) {
            return back()->with('error', 'Training failed: ' . $e->getMessage());
        }
    }
    
    public function destroy(TrainingData $trainingData)
    {
        $trainingData->delete();
        
        return back()->with('success', 'Training sample deleted!');
    }
}