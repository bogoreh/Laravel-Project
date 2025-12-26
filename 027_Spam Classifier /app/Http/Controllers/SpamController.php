<?php

namespace App\Http\Controllers;

use App\Services\SpamClassifierService;
use App\Models\SpamLog;
use Illuminate\Http\Request;

class SpamController extends Controller
{
    protected $classifier;
    
    public function __construct()
    {
        $this->classifier = new SpamClassifierService();
    }
    
    public function checkForm()
    {
        return view('spam.check', [
            'modelExists' => $this->classifier->modelExists(),
        ]);
    }
    
    public function check(Request $request)
    {
        $request->validate([
            'text' => 'required|string|min:5|max:1000',
        ]);
        
        $result = $this->classifier->predict($request->text);
        
        // Log the check
        SpamLog::create([
            'content' => $request->text,
            'spam_probability' => $result['probability'],
            'is_spam' => $result['is_spam'],
            'source' => $request->ip(),
            'features' => $result['features'],
        ]);
        
        return view('spam.result', [
            'result' => $result,
            'text' => $request->text,
        ]);
    }
    
    public function stats()
    {
        $total = SpamLog::count();
        $spam = SpamLog::where('is_spam', true)->count();
        $ham = SpamLog::where('is_spam', false)->count();
        
        return view('spam.stats', compact('total', 'spam', 'ham'));
    }
}