@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <div class="dark-gradient rounded-2xl shadow-2xl overflow-hidden mb-12">
        <div class="relative">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            </div>
            
            <!-- Content -->
            <div class="relative py-16 px-8 md:px-16">
                <div class="max-w-4xl">
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-purple-900/30 to-blue-900/30 border border-purple-700/30 mb-6">
                        <span class="w-2 h-2 rounded-full bg-purple-400 mr-2 animate-pulse"></span>
                        <span class="text-sm font-medium text-purple-300">PREMIUM MUSIC COLLECTION</span>
                    </div>
                    
                    <h1 class="text-5xl md:text-6xl font-bold mb-6">
                        <span class="bg-gradient-to-r from-white via-purple-100 to-blue-100 bg-clip-text text-transparent">
                            Discover Your Next
                        </span>
                        <br>
                        <span class="bg-gradient-to-r from-purple-400 via-pink-400 to-blue-400 bg-clip-text text-transparent">
                            Favorite Album
                        </span>
                    </h1>
                    
                    <p class="text-xl text-gray-300 mb-8 max-w-2xl">
                        Explore thousands of albums from legendary artists and emerging talents. 
                        From classic rock to modern electronic, find the perfect soundtrack for every moment.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('browse') }}" 
                           class="btn-primary px-8 py-4 rounded-xl font-bold text-lg inline-flex items-center justify-center">
                            Start Exploring <i class="fas fa-arrow-right ml-3"></i>
                        </a>
                        <a href="#featured" 
                           class="btn-secondary px-8 py-4 rounded-xl font-bold text-lg inline-flex items-center justify-center">
                            <i class="fas fa-play-circle mr-3"></i> Featured Albums
                        </a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="text-center p-4 bg-white/5 backdrop-blur-sm rounded-xl border border-white/10">
                            <div class="text-3xl font-bold text-white mb-1">5,000+</div>
                            <div class="text-sm text-gray-400">Albums</div>
                        </div>
                        <div class="text-center p-4 bg-white/5 backdrop-blur-sm rounded-xl border border-white/10">
                            <div class="text-3xl font-bold text-white mb-1">1,200+</div>
                            <div class="text-sm text-gray-400">Artists</div>
                        </div>
                        <div class="text-center p-4 bg-white/5 backdrop-blur-sm rounded-xl border border-white/10">
                            <div class="text-3xl font-bold text-white mb-1">50+</div>
                            <div class="text-sm text-gray-400">Genres</div>
                        </div>
                        <div class="text-center p-4 bg-white/5 backdrop-blur-sm rounded-xl border border-white/10">
                            <div class="text-3xl font-bold text-white mb-1">24/7</div>
                            <div class="text-sm text-gray-400">Support</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Albums -->
    <div id="featured" class="mb-16">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <div class="inline-flex items-center mb-2">
                    <div class="w-4 h-0.5 bg-gradient-to-r from-purple-500 to-blue-500 mr-2"></div>
                    <span class="text-sm font-semibold text-gray-500 uppercase tracking-wider">FEATURED SELECTION</span>
                </div>
                <h2 class="text-4xl font-bold text-gray-800">Trending Albums</h2>
                <p class="text-gray-600 mt-2">Discover what's hot in music right now</p>
            </div>
            <a href="{{ route('browse') }}" 
               class="mt-4 md:mt-0 inline-flex items-center text-purple-600 hover:text-purple-800 font-semibold group">
                View All Albums
                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($albums as $album)
                <div class="album-card bg-white rounded-xl overflow-hidden shadow-sm">
                    <a href="{{ route('album.detail', $album->id) }}" class="block">
                        <div class="relative overflow-hidden">
                            <img src="{{ $album->cover_image ?: 'https://via.placeholder.com/300x300?text=Album+Cover' }}" 
                                 alt="{{ $album->title }}"
                                 class="w-full h-48 object-cover transform hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 hover:opacity-100 transition-opacity">
                                <div class="absolute bottom-4 left-4 right-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-white text-sm font-medium">{{ $album->genre }}</span>
                                        <span class="text-white text-sm">{{ $album->release_year }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-lg mb-1 truncate text-gray-800">{{ $album->title }}</h3>
                            <p class="text-gray-600 mb-3">{{ $album->artist->name }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">
                                    {{ $album->formatted_price }}
                                </span>
                                @if($album->stock_quantity > 0)
                                    <form action="{{ route('cart.add', $album->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-500 to-blue-500 text-white flex items-center justify-center hover:shadow-lg transition-all">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Featured Artists -->
    <div class="mb-12">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <div class="inline-flex items-center mb-2">
                    <div class="w-4 h-0.5 bg-gradient-to-r from-purple-500 to-blue-500 mr-2"></div>
                    <span class="text-sm font-semibold text-gray-500 uppercase tracking-wider">TOP ARTISTS</span>
                </div>
                <h2 class="text-4xl font-bold text-gray-800">Featured Artists</h2>
                <p class="text-gray-600 mt-2">Explore music from industry legends</p>
            </div>
            <a href="{{ route('artists') }}" 
               class="mt-4 md:mt-0 inline-flex items-center text-purple-600 hover:text-purple-800 font-semibold group">
                View All Artists
                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredArtists as $artist)
                <a href="{{ route('artist.detail', $artist->id) }}" 
                   class="group">
                    <div class="bg-gradient-to-br from-gray-900 to-black rounded-xl p-6 text-center shadow-xl hover:shadow-2xl transition-all duration-300">
                        <div class="relative inline-block mb-4">
                            <img src="{{ $artist->image ?: 'https://via.placeholder.com/150x150?text=Artist' }}" 
                                 alt="{{ $artist->name }}"
                                 class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-gray-800 group-hover:border-purple-500 transition-colors">
                            <div class="absolute -bottom-2 -right-2 w-10 h-10 rounded-full bg-gradient-to-r from-purple-600 to-blue-600 flex items-center justify-center">
                                <i class="fas fa-music text-white text-sm"></i>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-1">{{ $artist->name }}</h3>
                        <p class="text-gray-400 mb-3">{{ $artist->genre }}</p>
                        <div class="inline-flex items-center px-3 py-1 rounded-full bg-gray-800">
                            <i class="fas fa-compact-disc text-purple-400 mr-2 text-sm"></i>
                            <span class="text-sm text-gray-300">{{ $artist->albums_count }} albums</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- CTA Section -->
    <div class="dark-gradient rounded-2xl shadow-2xl p-8 md:p-12 text-center">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                Ready to Build Your Collection?
            </h2>
            <p class="text-gray-300 mb-8 text-lg">
                Join thousands of music lovers who trust MusicStore for their musical journey. 
                From rare vinyl to digital exclusives, we have it all.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('browse') }}" 
                   class="px-8 py-4 bg-white text-gray-900 rounded-xl font-bold text-lg hover:bg-gray-100 transition inline-flex items-center justify-center">
                    <i class="fas fa-shopping-bag mr-3"></i> Start Shopping
                </a>
                <a href="{{ route('artists') }}" 
                   class="px-8 py-4 bg-transparent border-2 border-white/30 text-white rounded-xl font-bold text-lg hover:bg-white/10 transition inline-flex items-center justify-center">
                    <i class="fas fa-users mr-3"></i> Explore Artists
                </a>
            </div>
        </div>
    </div>
@endsection