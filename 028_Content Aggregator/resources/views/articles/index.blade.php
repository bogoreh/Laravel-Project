@extends('layouts.app')

@section('title', 'Latest Articles')

@section('content')
    <!-- Filters Section -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <form action="{{ route('articles.index') }}" method="GET" class="space-y-4 md:space-y-0 md:flex md:space-x-4">
            <!-- Search -->
            <div class="flex-grow">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search articles..." 
                           class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <i class="fas fa-search absolute left-4 top-3.5 text-gray-400"></i>
                </div>
            </div>

            <!-- Source Filter -->
            <div class="md:w-64">
                <select name="source" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">All Sources</option>
                    @foreach($sources as $source)
                        <option value="{{ $source->id }}" {{ request('source') == $source->id ? 'selected' : '' }}>
                            {{ $source->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Category Filter -->
            <div class="md:w-64">
                <select name="category" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        @if($category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-3">
                <button type="submit" class="gradient-bg text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                <a href="{{ route('articles.index') }}" class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300">
                    <i class="fas fa-redo mr-2"></i>Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-newspaper text-blue-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500">Total Articles</p>
                    <p class="text-3xl font-bold">{{ $articles->total() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-rss text-green-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500">Active Sources</p>
                    <p class="text-3xl font-bold">{{ $sources->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-tags text-purple-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500">Categories</p>
                    <p class="text-3xl font-bold">{{ $categories->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Articles Grid -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Latest Articles</h2>
        
        @if($articles->isEmpty())
            <div class="text-center py-12">
                <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg">No articles found. Try adjusting your filters.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($articles as $article)
                    <article class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                        @if($article->image_url)
                            <div class="h-48 overflow-hidden">
                                <img src="{{ $article->image_url }}" alt="{{ $article->title }}" 
                                     class="w-full h-full object-cover">
                            </div>
                        @endif
                        <div class="p-6">
                            @if($article->category)
                                <span class="category-badge bg-purple-100 text-purple-600 mb-3">
                                    {{ $article->category }}
                                </span>
                            @endif
                            <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">
                                {{ $article->title }}
                            </h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                {{ Str::limit(strip_tags($article->description), 150) }}
                            </p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full gradient-bg flex items-center justify-center text-white">
                                        {{ substr($article->source->name, 0, 1) }}
                                    </div>
                                    <span class="ml-2 text-sm text-gray-500">{{ $article->source->name }}</span>
                                </div>
                                <span class="text-sm text-gray-500">
                                    {{ $article->published_at->diffForHumans() }}
                                </span>
                            </div>
                            <a href="{{ route('articles.show', $article) }}" 
                               class="mt-4 inline-block text-purple-600 font-semibold hover:text-purple-700">
                                Read More <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($articles->hasPages())
        <div class="bg-white p-6 rounded-xl shadow-lg">
            {{ $articles->withQueryString()->links() }}
        </div>
    @endif
@endsection