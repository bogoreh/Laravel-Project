<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/watch/{id}', function ($id) {
    $movies = [
        '1' => [
            'title' => 'Stranger Things',
            'description' => 'When a young boy vanishes, a small town uncovers a mystery involving secret experiments.',
            'year' => '2016',
            'duration' => '4 Seasons',
            'genre' => 'Sci-Fi, Horror',
            'rating' => 'TV-14',
            'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4'
        ],
        '2' => [
            'title' => 'The Crown',
            'description' => 'Follows the political rivalries and romance of Queen Elizabeth II\'s reign.',
            'year' => '2016',
            'duration' => '6 Seasons',
            'genre' => 'Drama, History',
            'rating' => 'TV-MA',
            'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4'
        ],
        '3' => [
            'title' => 'Money Heist',
            'description' => 'An unusual group of robbers attempt to carry out the most perfect robbery.',
            'year' => '2017',
            'duration' => '5 Seasons',
            'genre' => 'Crime, Drama',
            'rating' => 'TV-MA',
            'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4'
        ],
        '4' => [
            'title' => 'The Witcher',
            'description' => 'Geralt of Rivia, a mutated monster-hunter for hire, journeys toward his destiny.',
            'year' => '2019',
            'duration' => '3 Seasons',
            'genre' => 'Fantasy, Action',
            'rating' => 'TV-MA',
            'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4'
        ]
    ];

    $movie = $movies[$id] ?? $movies['1'];

    return view('watch', compact('movie'));
});

Route::get('/browse', function () {
    $categories = [
        'Popular on Netflix' => [1, 2, 3, 4],
        'Continue Watching' => [3, 4, 1, 2],
        'Trending Now' => [2, 1, 4, 3],
        'Sci-Fi Movies' => [1, 4, 2, 3],
        'Drama Series' => [2, 3, 1, 4]
    ];

    $allMovies = [
        1 => ['title' => 'Stranger Things', 'image' => 'https://images.unsplash.com/photo-1489599809516-9827b6d1cf13?w=400&h=225&fit=crop', 'genre' => 'Sci-Fi'],
        2 => ['title' => 'The Crown', 'image' => 'https://images.unsplash.com/photo-1536440136628-849c177e76a1?w=400&h=225&fit=crop', 'genre' => 'Drama'],
        3 => ['title' => 'Money Heist', 'image' => 'https://images.unsplash.com/photo-1574269909862-7e1d70bb8078?w-400&h=225&fit=crop', 'genre' => 'Crime'],
        4 => ['title' => 'The Witcher', 'image' => 'https://images.unsplash.com/photo-1518709268805-4e9042af2176?w=400&h=225&fit=crop', 'genre' => 'Fantasy']
    ];

    return view('browse', compact('categories', 'allMovies'));
});