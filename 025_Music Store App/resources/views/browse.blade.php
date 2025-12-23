@extends('layouts.app')

@section('title', 'Browse Albums')

@section('content')
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Browse Albums</h1>
        <p class="text-gray-600">Discover music from all genres</p>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('browse') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-grow">
                <input type="text" 
                       name="search" 
                       placeholder="Search albums or artists..." 
                       value="{{ request('search') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            
            <div class="w-full md:w-64">
                <select name="genre" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="all" {{ request('genre') == 'all' ? 'selected' : '' }}>All Genres</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>
                            {{ $genre }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <button type="submit" 
                    class="music-gradient text-white px-6 py-2 rounded-lg font-bold hover:opacity-90 transition duration-300">
                Search
            </button>
            
            @if(request()->has('search') || request()->has('genre') && request('genre') != 'all')
                <a href="{{ route('browse') }}" 
                   class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-bold hover:bg-gray-300 transition duration-300">
                    Clear Filters
                </a>
            @endif
        </form>
    </div>

    <!-- Albums Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($albums as $album)
            <div class="album-card bg-white rounded-xl shadow-md overflow-hidden">
                <a href="{{ route('album.detail', $album->id) }}">
                    <div class="relative">
                        <img src="{{ $album->cover_image ?: 'https://via.placeholder.com/300x300?text=Album+Cover' }}" 
                             alt="{{ $album->title }}"
                             class="w-full h-48 object-cover">
                        @if($album->stock_quantity > 0)
                            <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                                In Stock
                            </span>
                        @else
                            <span class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                Out of Stock
                            </span>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-1 truncate">{{ $album->title }}</h3>
                        <p class="text-gray-600 mb-2">{{ $album->artist->name }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-purple-600 font-bold">{{ $album->formatted_price }}</span>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-500">{{ $album->genre }}</span>
                                <form action="{{ route('cart.add', $album->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="music-gradient text-white p-2 rounded-full hover:opacity-90 transition duration-300"
                                            {{ $album->stock_quantity == 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-music text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">No albums found</h3>
                <p class="text-gray-600">Try adjusting your search or filter criteria</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($albums->hasPages())
        <div class="mt-8">
            {{ $albums->links() }}
        </div>
    @endif
@endsection