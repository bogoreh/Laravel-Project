@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex h-[calc(100vh-120px)] bg-white rounded-2xl shadow-lg overflow-hidden">
        <!-- Sidebar -->
        <div class="w-1/4 border-r border-gray-200 flex flex-col">
            <!-- New Chat Button -->
            <div class="p-4 border-b border-gray-200">
                <button onclick="openUserModal()" 
                        class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200 flex items-center justify-center space-x-2">
                    <i class="fas fa-plus"></i>
                    <span>New Chat</span>
                </button>
            </div>

            <!-- Conversations List -->
            <div class="flex-1 overflow-y-auto">
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Conversations</h3>
                    <div class="space-y-2">
                        @foreach($conversations as $conv)
                        <a href="{{ route('chat.show', $conv) }}" 
                           class="block p-3 rounded-lg transition duration-200 {{ $conversation->id == $conv->id ? 'bg-blue-100 border border-blue-300' : 'hover:bg-gray-100' }}">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ substr($conv->title, 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $conv->title }}
                                    </p>
                                    <p class="text-xs text-gray-500 truncate">
                                        @if($conv->messages->last())
                                            {{ Str::limit($conv->messages->last()->body, 30) }}
                                        @else
                                            No messages yet
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="flex-1 flex flex-col">
            @if(isset($conversation))
            <!-- Chat Header -->
            <div class="border-b border-gray-200 p-4 bg-white">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                        {{ substr($conversation->title, 0, 1) }}
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900">{{ $conversation->title }}</h2>
                </div>
            </div>

            <!-- Messages -->
            <div id="messages-container" class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50">
                @foreach($messages as $message)
                <div class="flex {{ $message->user_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-2xl {{ $message->user_id == Auth::id() ? 'bg-blue-600 text-white rounded-br-none' : 'bg-white text-gray-800 rounded-bl-none border border-gray-200' }}">
                        <div class="text-sm">{{ $message->body }}</div>
                        <div class="text-xs mt-1 {{ $message->user_id == Auth::id() ? 'text-blue-200' : 'text-gray-500' }}">
                            {{ $message->user->name }} • {{ $message->created_at->format('H:i') }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Message Input -->
            <div class="border-t border-gray-200 p-4 bg-white">
                <form id="message-form" class="flex space-x-4">
                    @csrf
                    <input type="text" 
                           name="body" 
                           id="message-input"
                           placeholder="Type your message..." 
                           class="flex-1 border border-gray-300 rounded-full px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <button type="submit" 
                            class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center hover:bg-blue-700 transition duration-200">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
            @else
            <!-- Welcome Screen -->
            <div class="flex-1 flex items-center justify-center bg-gray-50">
                <div class="text-center">
                    <i class="fas fa-comments text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-2xl font-semibold text-gray-600 mb-2">Welcome to Chat System</h3>
                    <p class="text-gray-500">Select a conversation or start a new one to begin chatting</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- User Selection Modal -->
<div id="userModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 w-96 max-w-full mx-4">
        <h3 class="text-lg font-semibold mb-4">Start New Conversation</h3>
        <form method="POST" action="{{ route('chat.conversation.create') }}">
            @csrf
            <div class="space-y-3 max-h-60 overflow-y-auto mb-4">
                @foreach($users as $user)
                <label class="flex items-center space-x-3 p-2 hover:bg-gray-100 rounded-lg cursor-pointer">
                    <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="rounded text-blue-600">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <span class="text-gray-700">{{ $user->name }}</span>
                </label>
                @endforeach
            </div>
            <div class="flex space-x-3">
                <button type="button" onclick="closeUserModal()" 
                        class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 transition duration-200">
                    Cancel
                </button>
                <button type="submit" 
                        class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                    Start Chat
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openUserModal() {
    document.getElementById('userModal').classList.remove('hidden');
    document.getElementById('userModal').classList.add('flex');
}

function closeUserModal() {
    document.getElementById('userModal').classList.remove('flex');
    document.getElementById('userModal').classList.add('hidden');
}

@if(isset($conversation))
// Auto-scroll to bottom
function scrollToBottom() {
    const container = document.getElementById('messages-container');
    container.scrollTop = container.scrollHeight;
}

// Handle message submission
document.getElementById('message-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const input = document.getElementById('message-input');
    const message = input.value.trim();
    
    if (!message) return;
    
    fetch('{{ route("chat.message.store", $conversation) }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            input.value = '';
            // In a real app, you'd append the new message to the chat
            location.reload(); // Simple reload for demo
        }
    })
    .catch(error => console.error('Error:', error));
});

// Scroll to bottom on load
document.addEventListener('DOMContentLoaded', scrollToBottom);
@endif

// Close modal when clicking outside
document.getElementById('userModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeUserModal();
    }
});
</script>
@endpush