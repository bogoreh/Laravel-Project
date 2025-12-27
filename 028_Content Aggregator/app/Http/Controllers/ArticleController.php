<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Source;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with('source')->latest('published_at');
        
        // Filter by source
        if ($request->has('source')) {
            $query->whereHas('source', function($q) use ($request) {
                $q->where('id', $request->source);
            });
        }

        // Filter by category
        if ($request->has('category')) {
            $query->where('category', 'like', '%' . $request->category . '%');
        }

        // Search
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $articles = $query->paginate(12);
        $sources = Source::where('is_active', true)->get();
        $categories = Article::select('category')->distinct()->pluck('category')->filter();

        return view('articles.index', compact('articles', 'sources', 'categories'));
    }

    public function show(Article $article)
    {
        $article->load('source');
        $related = Article::where('category', $article->category)
            ->where('id', '!=', $article->id)
            ->limit(4)
            ->get();

        return view('articles.show', compact('article', 'related'));
    }
}