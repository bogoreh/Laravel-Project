@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Current Time -->
    <div class="bg-white rounded-lg shadow-lg p-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Current Time</h2>
        <div class="text-5xl font-bold text-blue-600" id="current-time">
            {{ now()->format('H:i:s') }}
        </div>
        <div class="text-xl text-gray-600 mt-2">
            {{ now()->format('l, F j, Y') }}
        </div>
    </div>

    <!-- Active Alarms -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Active Alarms</h2>
        @php
            $activeAlarms = \App\Models\Alarm::where('is_active', true)->get();
        @endphp
        @if($activeAlarms->count() > 0)
            <div class="space-y-3">
                @foreach($activeAlarms as $alarm)
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded">
                        <div>
                            <span class="font-bold">{{ $alarm->title }}</span>
                            <span class="ml-2 px-2 py-1 bg-blue-100 text-blue-800 rounded text-sm">
                                {{ \Carbon\Carbon::parse($alarm->alarm_time)->format('h:i A') }}
                            </span>
                        </div>
                        <form action="{{ route('alarms.toggle', $alarm) }}" method="POST" class="toggle-form">
                            @csrf
                            @method('POST')
                            <button type="submit" class="text-green-600 hover:text-green-800">
                                <i class="fas fa-toggle-on fa-lg"></i>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No active alarms</p>
        @endif
        <a href="{{ route('alarms.create') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            <i class="fas fa-plus"></i> Add New Alarm
        </a>
    </div>

    <!-- Quick Notes -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Quick Notes</h2>
        <form action="{{ route('notes.store') }}" method="POST">
            @csrf
            <input type="text" name="title" placeholder="Note Title" 
                   class="w-full p-2 border rounded mb-2" required>
            <textarea name="content" placeholder="Note Content" 
                      class="w-full p-2 border rounded mb-2" rows="3" required></textarea>
            <div class="flex justify-between items-center">
                <div class="flex space-x-2">
                    <button type="button" class="color-btn w-6 h-6 rounded-full bg-white border" data-color="#ffffff"></button>
                    <button type="button" class="color-btn w-6 h-6 rounded-full bg-yellow-100" data-color="#fef3c7"></button>
                    <button type="button" class="color-btn w-6 h-6 rounded-full bg-blue-100" data-color="#dbeafe"></button>
                    <button type="button" class="color-btn w-6 h-6 rounded-full bg-green-100" data-color="#d1fae5"></button>
                </div>
                <input type="hidden" name="color" id="note-color" value="#ffffff">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    <i class="fas fa-save"></i> Save
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Alarm Modal (hidden by default) -->
<div id="alarm-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-8 max-w-2xl w-full mx-4">
        <h2 class="text-3xl font-bold text-red-600 mb-4">
            <i class="fas fa-bell"></i> Alarm!
        </h2>
        <div id="alarm-content">
            <!-- Alarm content will be loaded here -->
        </div>
        <div class="mt-6 flex space-x-4">
            <button id="snooze-btn" class="bg-yellow-500 text-white px-6 py-3 rounded-lg hover:bg-yellow-600">
                <i class="fas fa-clock"></i> Snooze (5 min)
            </button>
            <button id="stop-btn" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700">
                <i class="fas fa-stop"></i> Stop Alarm
            </button>
        </div>
    </div>
</div>

<audio id="alarm-sound" loop>
    <source src="{{ asset('default-alarm.mp3') }}" type="audio/mpeg">
</audio>

<video id="alarm-video" class="hidden" loop>
    Your browser does not support the video tag.
</video>

<script>
$(document).ready(function() {
    // Update current time
    function updateTime() {
        const now = new Date();
        const timeStr = now.toLocaleTimeString('en-US', {hour12: false});
        $('#current-time').text(timeStr);
    }
    setInterval(updateTime, 1000);

    // Color picker for notes
    $('.color-btn').click(function() {
        const color = $(this).data('color');
        $('#note-color').val(color);
        $('.color-btn').removeClass('border-2 border-blue-500');
        $(this).addClass('border-2 border-blue-500');
    });

    // Check for alarms every minute
    function checkAlarms() {
        $.get('/alarm-trigger', function(response) {
            if (response.alarms.length > 0) {
                triggerAlarm(response.alarms[0]);
            }
        });
    }

    // Check every 60 seconds
    setInterval(checkAlarms, 60000);

    function triggerAlarm(alarm) {
        // Show modal
        $('#alarm-content').html(`
            <h3 class="text-2xl font-bold mb-2">${alarm.title}</h3>
            <p class="text-gray-600 mb-4">${alarm.description || 'Time to wake up!'}</p>
            <p class="text-lg">Alarm Time: ${alarm.alarm_time}</p>
        `);

        // Play audio if available
        if (alarm.audio_url) {
            $('#alarm-sound source').attr('src', alarm.audio_url);
            $('#alarm-sound')[0].load();
        }
        $('#alarm-sound')[0].play();

        // Play video if available
        if (alarm.video_url) {
            $('#alarm-video source').attr('src', alarm.video_url);
            $('#alarm-video')[0].load();
            $('#alarm-video')[0].play();
            $('#alarm-video').removeClass('hidden');
        }

        $('#alarm-modal').removeClass('hidden');

        // Log alarm trigger
        $.post('/api/alarm-log', {
            alarm_id: alarm.id,
            triggered_at: new Date().toISOString(),
            _token: '{{ csrf_token() }}'
        });
    }

    $('#stop-btn').click(function() {
        $('#alarm-sound')[0].pause();
        $('#alarm-video')[0].pause();
        $('#alarm-video').addClass('hidden');
        $('#alarm-modal').addClass('hidden');
        
        // Log stop
        $.post('/api/alarm-log/stop', {
            alarm_id: $(this).data('alarm-id'),
            _token: '{{ csrf_token() }}'
        });
    });

    $('#snooze-btn').click(function() {
        $('#alarm-sound')[0].pause();
        $('#alarm-video')[0].pause();
        $('#alarm-video').addClass('hidden');
        $('#alarm-modal').addClass('hidden');
        
        // Snooze for 5 minutes
        setTimeout(function() {
            checkAlarms();
        }, 5 * 60 * 1000);
        
        // Log snooze
        $.post('/api/alarm-log/snooze', {
            alarm_id: $(this).data('alarm-id'),
            _token: '{{ csrf_token() }}'
        });
    });

    // Toggle alarm active state
    $('.toggle-form').submit(function(e) {
        e.preventDefault();
        const form = $(this);
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.is_active) {
                    form.find('button').html('<i class="fas fa-toggle-on fa-lg"></i>');
                    form.find('button').removeClass('text-red-600').addClass('text-green-600');
                } else {
                    form.find('button').html('<i class="fas fa-toggle-off fa-lg"></i>');
                    form.find('button').removeClass('text-green-600').addClass('text-red-600');
                }
            }
        });
    });
});
</script>
@endsection