@extends('layouts.app')

@section('content')
    <nav class="navbar">
        <a href="/" class="logo">NETFLIX</a>
        <div class="nav-links">
            <a href="/">Home</a>
            <a href="/browse">Browse</a>
        </div>
    </nav>

    <div class="player-container">
        <video controls autoplay>
            <source src="{{ $movie['video_url'] }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        
        <div class="player-overlay">
            <h1>{{ $movie['title'] }}</h1>
            <p>{{ $movie['description'] }}</p>
            <a href="/browse" class="btn" style="margin-top: 20px;">Browse More</a>
        </div>
    </div>

    <div class="container movie-details">
        <h1>{{ $movie['title'] }}</h1>
        
        <div class="details-grid">
            <div>
                <h3>Description</h3>
                <p style="margin-top: 10px; line-height: 1.6;">{{ $movie['description'] }}</p>
            </div>
            
            <div>
                <div class="info-item">
                    <div class="info-label">Year</div>
                    <div class="info-value">{{ $movie['year'] }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Duration</div>
                    <div class="info-value">{{ $movie['duration'] }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Genre</div>
                    <div class="info-value">{{ $movie['genre'] }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Rating</div>
                    <div class="info-value">{{ $movie['rating'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>This is a Netflix clone for educational purposes only.</p>
        <p>© 2024 Netflix Clone. All rights reserved.</p>
    </footer>
@endsection