<?php

namespace App\Http\Middleware;

use App\Services\SpamClassifierService;
use Closure;
use Illuminate\Http\Request;

class SpamFilterMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('message') || $request->has('content')) {
            $classifier = new SpamClassifierService();
            
            $text = $request->input('message') ?? $request->input('content');
            $result = $classifier->predict($text);
            
            if ($result['is_spam']) {
                return response()->json([
                    'error' => 'Spam detected',
                    'probability' => $result['probability']
                ], 422);
            }
        }
        
        return $next($request);
    }
}