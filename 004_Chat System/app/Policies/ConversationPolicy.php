<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ConversationPolicy
{
    public function view(User $user, Conversation $conversation)
    {
        return $conversation->users->contains($user)
            ? Response::allow()
            : Response::deny('You do not have access to this conversation.');
    }
}