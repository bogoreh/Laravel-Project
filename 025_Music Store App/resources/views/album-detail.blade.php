@extends('layouts.app')

@section('title', $album->title)

@section('content')
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="md:flex">
            <!-- Album Cover -->
            <div class="md:w-1/3 p-8">
                <img src="{{ $album->cover_image ?: 'https://via.placeholder.com/400x400?text=Album+Cover' }}" 
                     alt="{{ $album->title }}"
                     class="w-full rounded-lg shadow-md">
            </div>
            
            <!-- Album Info -->
            <div class="md:w-2/3 p-8">
                <div class="mb-6">
                    <span class="bg-purple-100 text-purple-800 text-sm font-medium px-3 py-1 rounded-full">
                        {{ $album->genre }}
                    </span>
                    <h1 class="text-4xl font-bold mt-2 mb-2">{{ $album->title }}</h1>
                    <a href="{{ route('artist.detail', $album->artist->id) }}" 
                       class="text-2xl text-purple-600 hover:text-purple-800 font-medium">
                        {{ $album->artist->name }}
                    </a>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">{{ $album->formatted_price }}</div>
                        <div class="text-sm text-gray-600">Price</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">{{ $album->release_year }}</div>
                        <div class="text-sm text-gray-600">Release Year</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">{{ $album->duration }}</div>
                        <div class="text-sm text-gray-600">Duration</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">{{ $album->stock_quantity }}</div>
                        <div class="text-sm text-gray-600">In Stock</div>
                    </div>
                </div>
                
                @if($album->stock_quantity > 0)
                    <form action="{{ route('cart.add', $album->id) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="music-gradient text-white px-8 py-3 rounded-full font-bold text-lg hover:opacity-90 transition duration-300 flex items-center">
                            <i class="fas fa-cart-plus mr-2"></i>
                            Add to Cart - {{ $album->formatted_price }}
                        </button>
                    </form>
                @else
                    <button disabled 
                            class="bg-gray-300 text-gray-500 px-8 py-3 rounded-full font-bold text-lg cursor-not-allowed">
                        Out of Stock
                    </button>
                @endif
                
                @if($album->artist->bio)
                    <div class="mt-8">
                        <h3 class="text-xl font-bold mb-2">About the Artist</h3>
                        <p class="text-gray-700">{{ Str::limit($album->artist->bio, 300) }}</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Track List -->
        <div class="border-t border-gray-200 p-8">
            <h2 class="text-2xl font-bold mb-4">Track List</h2>
            <div class="space-y-2">
                @foreach($album->tracks as $track)
                    <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <span class="text-gray-500 w-8">{{ $track->track_number }}</span>
                            <span class="font-medium">{{ $track->title }}</span>
                        </div>
                        <span class="text-gray-500">{{ $track->formatted_duration }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Related Albums -->
    @if($relatedAlbums->count() > 0)
        <div class="mt-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">You Might Also Like</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedAlbums as $relatedAlbum)
                    <div class="album-card bg-white rounded-xl shadow-md overflow-hidden">
                        <a href="{{ route('album.detail', $relatedAlbum->id) }}">
                            <img src="{{ $relatedAlbum->cover_image ?: 'https://via.placeholder.com/300x300?text=Album+Cover' }}" 
                                 alt="{{ $relatedAlbum->title }}"
                                 class="w-full h-40 object-cover">
                            <div class="p-4">
                                <h3 class="font-bold truncate">{{ $relatedAlbum->title }}</h3>
                                <p class="text-sm text-gray-600 truncate">{{ $relatedAlbum->artist->name }}</p>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-purple-600 font-bold">{{ $relatedAlbum->formatted_price }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection