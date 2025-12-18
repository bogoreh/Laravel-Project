@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-800">Alarms</h1>
    <a href="{{ route('alarms.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        <i class="fas fa-plus"></i> Add New Alarm
    </a>
</div>

<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-3 px-4 text-left">Status</th>
                <th class="py-3 px-4 text-left">Title</th>
                <th class="py-3 px-4 text-left">Time</th>
                <th class="py-3 px-4 text-left">Days</th>
                <th class="py-3 px-4 text-left">Media</th>
                <th class="py-3 px-4 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alarms as $alarm)
            <tr class="border-t hover:bg-gray-50">
                <td class="py-3 px-4">
                    <form action="{{ route('alarms.toggle', $alarm) }}" method="POST" class="toggle-form inline">
                        @csrf @method('POST')
                        <button type="submit" class="text-2xl">
                            @if($alarm->is_active)
                                <i class="fas fa-toggle-on text-green-600"></i>
                            @else
                                <i class="fas fa-toggle-off text-red-600"></i>
                            @endif
                        </button>
                    </form>
                </td>
                <td class="py-3 px-4 font-medium">{{ $alarm->title }}</td>
                <td class="py-3 px-4">
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                        {{ \Carbon\Carbon::parse($alarm->alarm_time)->format('h:i A') }}
                    </span>
                </td>
                <td class="py-3 px-4">
                    @if($alarm->days)
                        @foreach($alarm->days as $day)
                            <span class="inline-block bg-gray-200 px-2 py-1 rounded text-sm mr-1">
                                {{ ucfirst($day) }}
                            </span>
                        @endforeach
                    @else
                        <span class="text-gray-500">Everyday</span>
                    @endif
                </td>
                <td class="py-3 px-4">
                    @if($alarm->video_url)
                        <i class="fas fa-video text-blue-500 mr-2"></i>
                    @endif
                    @if($alarm->audio_url)
                        <i class="fas fa-music text-green-500"></i>
                    @endif
                </td>
                <td class="py-3 px-4">
                    <div class="flex space-x-2">
                        <a href="{{ route('alarms.edit', $alarm) }}" 
                           class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('alarms.destroy', $alarm) }}" method="POST" 
                              onsubmit="return confirm('Delete this alarm?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if($alarms->isEmpty())
<div class="text-center py-12 text-gray-500">
    <i class="fas fa-bell-slash text-5xl mb-4"></i>
    <p class="text-xl">No alarms set yet</p>
</div>
@endif
@endsection