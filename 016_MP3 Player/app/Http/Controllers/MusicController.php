<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MusicController extends Controller
{
    public function index()
    {
        $songs = Song::orderBy('created_at', 'desc')->get();
        return view('music.index', compact('songs'));
    }

    public function upload()
    {
        return view('music.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'album' => 'nullable|string|max:255',
            'song_file' => 'required|mimes:mp3|max:51200', // Max 50MB
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle song file upload
        $songFile = $request->file('song_file');
        $songPath = $songFile->store('music', 'public');

        // Handle cover image upload
        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverFile = $request->file('cover_image');
            $coverPath = $coverFile->store('covers', 'public');
        }

        // Get duration (in seconds)
        $getID3 = new \getID3();
        $fileInfo = $getID3->analyze($songFile->getPathname());
        $duration = $fileInfo['playtime_seconds'] ?? 0;

        Song::create([
            'title' => $request->title,
            'artist' => $request->artist,
            'album' => $request->album,
            'file_path' => $songPath,
            'cover_image' => $coverPath,
            'duration' => $duration
        ]);

        return redirect()->route('music.index')->with('success', 'Song uploaded successfully!');
    }

    public function destroy(Song $song)
    {
        // Delete files from storage
        Storage::disk('public')->delete($song->file_path);
        if ($song->cover_image) {
            Storage::disk('public')->delete($song->cover_image);
        }
        
        $song->delete();
        
        return redirect()->route('music.index')->with('success', 'Song deleted successfully!');
    }
}