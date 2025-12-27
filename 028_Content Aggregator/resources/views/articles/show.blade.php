@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Article Header -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
            @if($article->category)
                <span class="category-badge bg-purple-100 text-purple-600 mb-4">
                    {{ $article->category }}
                </span>
            @endif
            
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                {{ $article->title }}
            </h1>
            
            <div class="flex items-center text-gray-600 mb-6">
                <div class="flex items-center mr-6">
                    <div class="w-10 h-10 rounded-full gradient-bg flex items-center justify-center text-white font-bold">
                        {{ substr($article->source->name, 0, 1) }}
                    </div>
                    <div class="ml-3">
                        <p class="font-semibold">{{ $article->source->name }}</p>
                        @if($article->author)
                            <p class="text-sm">By {{ $article->author }}</p>
                        @endif
                    </div>
                </div>
                <div class="text-sm">
                    <i class="far fa-clock mr-1"></i>
                    {{ $article->published_at->format('F j, Y') }}
                </div>
            </div>

            @if($article->image_url)
                <div class="mb-8">
                    <img src="{{ $article->image_url }}" alt="{{ $article->title }}" 
                         class="w-full h-auto rounded-lg shadow-md">
                </div>
            @endif
        </div>

        <!-- Article Content -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
            <div class="article-content text-gray-700 leading-relaxed">
                @if($article->content)
                    {!! $article->content !!}
                @else
                    <p class="text-lg">{{ $article->description }}</p>
                @endif
            </div>

            <div class="mt-8 pt-8 border-t border-gray-200">
                <a href="{{ $article->url }}" target="_blank" 
                   class="inline-flex items-center gradient-bg text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    Read Original Article
                </a>
            </div>
        </div>

        <!-- Related Articles -->
        @if($related->count() > 0)
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Related Articles</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($related as $relatedArticle)
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-300 hover:shadow-md">
                            <h3 class="font-bold text-gray-800 mb-2 line-clamp-2">
                                <a href="{{ route('articles.show', $relatedArticle) }}" class="hover:text-purple-600">
                                    {{ $relatedArticle->title }}
                                </a>
                            </h3>
                            <div class="flex items-center text-sm text-gray-500">
                                <span>{{ $relatedArticle->source->name }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $relatedArticle->published_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection