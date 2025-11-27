@extends('layouts.app')

@section('title', 'My Todo List')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">My Todo List</h1>
        <p class="text-gray-600">Stay organized and get things done</p>
    </div>

    <!-- Add Todo Button -->
    <div class="text-center mb-8">
        <a href="{{ route('todos.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition duration-300 transform hover:scale-105">
            <i class="fas fa-plus mr-2"></i>Add New Todo
        </a>
    </div>

    <!-- Todo List -->
    <div class="grid gap-6">
        @forelse($todos as $todo)
            <div class="todo-card bg-white rounded-xl shadow-lg p-6 border-l-4 {{ $todo->completed ? 'border-green-500' : 'border-blue-500' }}">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 flex-1">
                        <!-- Checkbox -->
                        <form action="{{ route('todos.toggle-complete', $todo) }}" method="POST" class="flex-shrink-0">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-6 h-6 rounded-full border-2 {{ $todo->completed ? 'bg-green-500 border-green-500' : 'border-gray-300' }} flex items-center justify-center transition duration-300 hover:scale-110">
                                @if($todo->completed)
                                    <i class="fas fa-check text-white text-xs"></i>
                                @endif
                            </button>
                        </form>

                        <!-- Content -->
                        <div class="flex-1 {{ $todo->completed ? 'completed' : '' }}">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $todo->title }}</h3>
                            @if($todo->description)
                                <p class="text-gray-600 mt-2">{{ $todo->description }}</p>
                            @endif
                            <p class="text-sm text-gray-500 mt-2">
                                Created: {{ $todo->created_at->format('M j, Y g:i A') }}
                            </p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-2 ml-4">
                        <!-- Edit Button -->
                        <a href="{{ route('todos.edit', $todo) }}" class="text-blue-500 hover:text-blue-700 transition duration-300 transform hover:scale-110" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>

                        <!-- Delete Button -->
                        <form action="{{ route('todos.destroy', $todo) }}" method="POST" onsubmit="return confirmDelete()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 transition duration-300 transform hover:scale-110" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="text-gray-400 text-6xl mb-4">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h3 class="text-2xl font-semibold text-gray-600 mb-2">No todos yet</h3>
                <p class="text-gray-500 mb-6">Get started by creating your first todo item!</p>
                <a href="{{ route('todos.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition duration-300">
                    Create Your First Todo
                </a>
            </div>
        @endforelse
    </div>

    <!-- Stats -->
    @if($todos->count() > 0)
        <div class="mt-8 text-center">
            <div class="inline-flex items-center space-x-6 bg-white rounded-lg shadow px-6 py-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $todos->count() }}</div>
                    <div class="text-sm text-gray-600">Total</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $todos->where('completed', true)->count() }}</div>
                    <div class="text-sm text-gray-600">Completed</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-orange-600">{{ $todos->where('completed', false)->count() }}</div>
                    <div class="text-sm text-gray-600">Pending</div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection