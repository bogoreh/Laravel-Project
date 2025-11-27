@extends('layouts.app')

@section('title', 'Edit Todo')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Edit Todo</h1>
            <p class="text-gray-600">Update your todo item</p>
        </div>

        <form action="{{ route('todos.update', $todo) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                    <input type="text" 
                           name="title" 
                           id="title"
                           value="{{ old('title', $todo->title) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                           placeholder="What needs to be done?"
                           required>
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" 
                              id="description"
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                              placeholder="Add some details (optional)">{{ old('description', $todo->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-between pt-6">
                    <a href="{{ route('todos.index') }}" class="flex items-center text-gray-600 hover:text-gray-800 transition duration-300">
                        <i class="fas fa-arrow-left mr-2"></i> Back to List
                    </a>
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-lg font-semibold transition duration-300 transform hover:scale-105">
                        <i class="fas fa-save mr-2"></i>Update Todo
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection