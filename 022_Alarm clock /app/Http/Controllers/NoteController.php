<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::orderBy('pinned', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->get();
        return view('notes.index', compact('notes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'color' => 'nullable|string|max:7',
            'pinned' => 'boolean'
        ]);

        Note::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'color' => $validated['color'] ?? '#ffffff',
            'pinned' => $request->has('pinned')
        ]);

        return redirect()->route('notes.index')->with('success', 'Note created successfully!');
    }

    public function update(Request $request, Note $note)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'color' => 'nullable|string|max:7',
            'pinned' => 'boolean'
        ]);

        $note->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'color' => $validated['color'] ?? '#ffffff',
            'pinned' => $request->has('pinned')
        ]);

        return redirect()->route('notes.index')->with('success', 'Note updated successfully!');
    }

    public function destroy(Note $note)
    {
        $note->delete();
        return redirect()->route('notes.index')->with('success', 'Note deleted successfully!');
    }

    public function togglePin(Note $note)
    {
        $note->update(['pinned' => !$note->pinned]);
        
        return response()->json([
            'success' => true,
            'pinned' => $note->pinned
        ]);
    }
}