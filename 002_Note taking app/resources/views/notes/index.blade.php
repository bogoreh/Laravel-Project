@extends('layouts.app')

@section('content')
<div class="px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">My Notes</h1>
        <p class="text-gray-600 mt-2">Manage your thoughts and ideas</p>
    </div>

    <!-- Notes Grid -->
    @if($notes->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($notes as $note)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300 transform hover:-translate-y-1"
                     style="background-color: {{ $note->color }};">
                    <div class="p-6">
                        <!-- Note Header -->
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $note->title }}</h3>
                            <div class="flex space-x-2">
                                <!-- Pin Button -->
                                <form action="{{ route('notes.toggle-pin', $note) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-gray-400 hover:text-yellow-500 transition duration-200">
                                        <i class="fas fa-thumbtack {{ $note->is_pinned ? 'text-yellow-500' : '' }}"></i>
                                    </button>
                                </form>
                                
                                <!-- Edit Button -->
                                <a href="{{ route('notes.edit', $note) }}" class="text-blue-400 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <!-- Delete Button -->
                                <form action="{{ route('notes.destroy', $note) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600 transition duration-200">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Note Content -->
                        <div class="text-gray-700 mb-4 line-clamp-3">
                            {{ Str::limit($note->content, 100) }}
                        </div>

                        <!-- Note Footer -->
                        <div class="flex justify-between items-center text-sm text-gray-500">
                            <span>{{ $note->created_at->format('M j, Y') }}</span>
                            <a href="{{ route('notes.show', $note) }}" class="text-blue-500 hover:text-blue-700 font-medium">
                                View <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="bg-white rounded-lg shadow-sm p-8 max-w-md mx-auto">
                <i class="fas fa-sticky-note text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No notes yet</h3>
                <p class="text-gray-500 mb-6">Start capturing your ideas and create your first note!</p>
                <a href="{{ route('notes.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                    <i class="fas fa-plus mr-2"></i> Create Your First Note
                </a>
            </div>
        </div>
    @endif
</div>

<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection