@extends('layouts.app')

@section('content')
    <nav class="navbar">
        <a href="/" class="logo">NETFLIX</a>
        <div class="nav-links">
            <a href="/">Home</a>
            <a href="/browse">Browse</a>
        </div>
    </nav>

    <div class="container">
        @foreach($categories as $categoryName => $movieIds)
            <h2 class="section-title">{{ $categoryName }}</h2>
            <div class="movie-row">
                @foreach($movieIds as $id)
                    @php
                        $movie = $allMovies[$id] ?? $allMovies[1];
                    @endphp
                    <a href="/watch/{{ $id }}" style="text-decoration: none;">
                        <div class="movie-card" style="background-image: url('{{ $movie['image'] }}');">
                            <div class="movie-info">
                                <div class="movie-title">{{ $movie['title'] }}</div>
                                <div class="movie-genre">{{ $movie['genre'] }}</div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endforeach
    </div>

    <footer>
        <p>This is a Netflix clone for educational purposes only.</p>
        <p>© 2024 Netflix Clone. All rights reserved.</p>
    </footer>
@endsection