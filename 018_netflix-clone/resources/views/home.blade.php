@extends('layouts.app')

@section('content')
    <nav class="navbar">
        <a href="/" class="logo">NETFLIX</a>
        <div class="nav-links">
            <a href="/">Home</a>
            <a href="/browse">Browse</a>
        </div>
    </nav>

    <div class="hero">
        <div class="hero-content">
            <h1>Unlimited movies, TV shows, and more.</h1>
            <p>Watch anywhere. Cancel anytime.</p>
            <div>
                <a href="/watch/1" class="btn">Watch Now</a>
                <a href="/browse" class="btn btn-secondary">Browse All</a>
            </div>
        </div>
    </div>

    <div class="container">
        <h2 class="section-title">Popular on Netflix</h2>
        <div class="movie-row">
            @foreach([1, 2, 3, 4] as $id)
                <a href="/watch/{{ $id }}" style="text-decoration: none;">
                    <div class="movie-card" style="background-image: url('https://images.unsplash.com/photo-1489599809516-9827b6d1cf13?w=400&h=600&fit=crop');">
                        <div class="movie-info">
                            <div class="movie-title">Stranger Things</div>
                            <div class="movie-genre">Sci-Fi, Horror</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <h2 class="section-title" style="margin-top: 40px;">Trending Now</h2>
        <div class="movie-row">
            @foreach([2, 3, 4, 1] as $id)
                <a href="/watch/{{ $id }}" style="text-decoration: none;">
                    <div class="movie-card" style="background-image: url('https://images.unsplash.com/photo-1536440136628-849c177e76a1?w=400&h=600&fit=crop');">
                        <div class="movie-info">
                            <div class="movie-title">The Crown</div>
                            <div class="movie-genre">Drama, History</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <footer>
        <p>This is a Netflix clone for educational purposes only.</p>
        <p>© 2024 Netflix Clone. All rights reserved.</p>
    </footer>
@endsection