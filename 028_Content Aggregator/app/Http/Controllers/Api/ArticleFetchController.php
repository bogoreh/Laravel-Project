<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Source;
use App\Services\RssFetcher;
use Illuminate\Http\Request;

class ArticleFetchController extends Controller
{
    public function fetch(Request $request)
    {
        try {
            $sources = Source::where('is_active', true)->get();
            $fetcher = new RssFetcher();
            
            $totalFetched = 0;
            foreach ($sources as $source) {
                $fetcher->fetch($source);
                $totalFetched++;
            }

            return response()->json([
                'success' => true,
                'message' => "Successfully fetched articles from {$totalFetched} sources."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching articles: ' . $e->getMessage()
            ], 500);
        }
    }
}