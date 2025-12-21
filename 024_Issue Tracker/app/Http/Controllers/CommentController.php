<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Issue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Issue $issue)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $comment = new Comment([
            'content' => $request->content,
            'user_id' => Auth::id()
        ]);

        $issue->comments()->save($comment);

        return redirect()->route('issues.show', $issue)
            ->with('success', 'Comment added successfully.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->back()
            ->with('success', 'Comment deleted successfully.');
    }
}