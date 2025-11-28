@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('notes.index') }}" class="inline-flex items-center text-blue-500 hover:text-blue-700 font-medium">
            <i class="fas fa-arrow-left mr-2"></i> Back to Notes
        </a>
    </div>

    <!-- Note Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden" style="background-color: {{ $note->color }};">
        <div class="p-8">
            <!-- Note Header -->
            <div class="flex justify-between items-start mb-6">
                <div>
                    @if($note->is_pinned)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 mb-2">
                            <i class="fas fa-thumbtack mr-1"></i> Pinned
                        </span>
                    @endif
                    <h1 class="text-3xl font-bold text-gray-900">{{ $note->title }}</h1>
                </div>
                <div class="flex space-x-3">
                    <!-- Edit Button -->
                    <a href="{{ route('notes.edit', $note) }}" 
                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </a>
                    
                    <!-- Delete Button -->
                    <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this note?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200">
                            <i class="fas fa-trash mr-2"></i> Delete
                        </button>
                    </form>
                </div>
            </div>

            <!-- Note Content -->
            <div class="prose max-w-none text-gray-700 mb-8">
                {!! nl2br(e($note->content)) !!}
            </div>

            <!-- Note Footer -->
            <div class="border-t pt-6">
                <div class="flex justify-between items-center text-sm text-gray-500">
                    <div>
                        <span class="font-medium">Created:</span> 
                        {{ $note->created_at->format('F j, Y \a\t g:i A') }}
                    </div>
                    <div>
                        <span class="font-medium">Last Updated:</span> 
                        {{ $note->updated_at->format('F j, Y \a\t g:i A') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection