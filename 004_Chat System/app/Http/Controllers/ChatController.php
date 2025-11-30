<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $conversations = Auth::user()->conversations()->with(['users', 'messages'])->get();
        $users = User::where('id', '!=', Auth::id())->get();
        
        return view('chat.index', compact('conversations', 'users'));
    }

    public function show(Conversation $conversation)
    {
        $this->authorize('view', $conversation);
        
        $conversations = Auth::user()->conversations()->with(['users', 'messages'])->get();
        $users = User::where('id', '!=', Auth::id())->get();
        $messages = $conversation->messages()->with('user')->latest()->take(50)->get()->reverse();

        return view('chat.index', compact('conversation', 'conversations', 'users', 'messages'));
    }

    public function storeMessage(Request $request, Conversation $conversation)
    {
        $this->authorize('view', $conversation);

        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $message = $conversation->messages()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        return response()->json([
            'success' => true,
            'message' => $message->load('user')
        ]);
    }

    public function createConversation(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $users = array_merge([Auth::id()], $request->user_ids);
        
        // Check if conversation already exists
        $existingConversation = Auth::user()->conversations()
            ->whereHas('users', function($query) use ($users) {
                $query->whereIn('users.id', $users);
            }, '=', count($users))
            ->first();

        if ($existingConversation) {
            return redirect()->route('chat.show', $existingConversation);
        }

        $conversation = Conversation::create([
            'title' => 'Chat with ' . User::whereIn('id', $request->user_ids)->pluck('name')->implode(', '),
        ]);

        $conversation->users()->attach($users);

        return redirect()->route('chat.show', $conversation);
    }
}