<?php

namespace App\Http\Controllers;

class VideoController extends Controller
{
    public function index()
    {
        // This could be extended to fetch videos from a database
        $videos = [
            [
                'title' => 'Pacman Gameplay',
                'url' => 'https://www.youtube.com/embed/dScq4P5gn4A',
                'type' => 'youtube'
            ],
            [
                'title' => 'Pacman History',
                'url' => 'https://www.youtube.com/embed/PO63Q0USa8E',
                'type' => 'youtube'
            ]
        ];

        return view('video.index', compact('videos'));
    }
}