<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::orderBy('is_pinned', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        return view('notes.index', compact('notes'));
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'color' => 'string|max:7',
        ]);

        Note::create([
            'title' => $request->title,
            'content' => $request->content,
            'color' => $request->color ?? '#ffffff',
            'is_pinned' => $request->has('is_pinned'),
        ]);

        return redirect()->route('notes.index')->with('success', 'Note created successfully!');
    }

    public function show(Note $note)
    {
        return view('notes.show', compact('note'));
    }

    public function edit(Note $note)
    {
        return view('notes.edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'color' => 'string|max:7',
        ]);

        $note->update([
            'title' => $request->title,
            'content' => $request->content,
            'color' => $request->color ?? '#ffffff',
            'is_pinned' => $request->has('is_pinned'),
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
        $note->update(['is_pinned' => !$note->is_pinned]);
        return back()->with('success', 'Note pin status updated!');
    }
}