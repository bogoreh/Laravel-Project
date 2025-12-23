<?php
namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;

class HomeController extends Controller {
    public function index() {
        $albums = Album::with('artist')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
        
        $featuredArtists = Artist::withCount('albums')
            ->orderBy('albums_count', 'desc')
            ->take(4)
            ->get();

        return view('home', compact('albums', 'featuredArtists'));
    }

    public function browse(Request $request) {
        $query = Album::with('artist');
        
        if ($request->has('genre') && $request->genre != 'all') {
            $query->where('genre', $request->genre);
        }
        
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhereHas('artist', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }
        
        $albums = $query->paginate(12);
        $genres = Album::distinct()->pluck('genre');
        
        return view('browse', compact('albums', 'genres'));
    }

    public function albumDetail($id) {
        $album = Album::with(['artist', 'tracks'])->findOrFail($id);
        $relatedAlbums = Album::where('genre', $album->genre)
            ->where('id', '!=', $id)
            ->take(4)
            ->get();
        
        return view('album-detail', compact('album', 'relatedAlbums'));
    }

    public function artistDetail($id) {
        $artist = Artist::with(['albums' => function($query) {
            $query->orderBy('release_year', 'desc');
        }])->findOrFail($id);
        
        return view('artist-detail', compact('artist'));
    }

    public function artists() {
        $artists = Artist::withCount('albums')
            ->orderBy('name')
            ->get();
        
        return view('artists', compact('artists'));
    }
}