@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-800">Notes</h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($notes as $note)
        <div class="rounded-lg shadow-lg p-4" style="background-color: {{ $note->color }}">
            <div class="flex justify-between items-start mb-3">
                <h3 class="text-xl font-bold">{{ $note->title }}</h3>
                <div class="flex space-x-2">
                    <form action="{{ route('notes.toggle-pin', $note) }}" method="POST" class="pin-form">
                        @csrf @method('POST')
                        <button type="submit" class="text-yellow-600 hover:text-yellow-800">
                            @if($note->pinned)
                                <i class="fas fa-thumbtack"></i>
                            @else
                                <i class="far fa-thumbtack"></i>
                            @endif
                        </button>
                    </form>
                    <form action="{{ route('notes.destroy', $note) }}" method="POST"
                          onsubmit="return confirm('Delete this note?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            <p class="text-gray-700 whitespace-pre-line">{{ $note->content }}</p>
            <div class="mt-4 text-sm text-gray-500">
                {{ $note->created_at->format('M d, Y') }}
            </div>
        </div>
    @endforeach
</div>

@if($notes->isEmpty())
<div class="text-center py-12 text-gray-500">
    <i class="fas fa-sticky-note text-5xl mb-4"></i>
    <p class="text-xl">No notes yet</p>
</div>
@endif

<script>
$(document).ready(function() {
    $('.pin-form').submit(function(e) {
        e.preventDefault();
        const form = $(this);
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.pinned) {
                    form.find('button').html('<i class="fas fa-thumbtack"></i>');
                } else {
                    form.find('button').html('<i class="far fa-thumbtack"></i>');
                }
            }
        });
    });
});
</script>
@endsection