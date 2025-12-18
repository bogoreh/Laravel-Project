@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        {{ isset($alarm) ? 'Edit Alarm' : 'Create New Alarm' }}
    </h1>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ isset($alarm) ? route('alarms.update', $alarm) : route('alarms.store') }}" 
              method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($alarm))
                @method('PUT')
            @endif

            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label class="block text-gray-700 mb-2">Alarm Title</label>
                    <input type="text" name="title" value="{{ old('title', $alarm->title ?? '') }}"
                           class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="3"
                              class="w-full p-3 border rounded-lg">{{ old('description', $alarm->description ?? '') }}</textarea>
                </div>

                <!-- Time -->
                <div>
                    <label class="block text-gray-700 mb-2">Alarm Time</label>
                    <input type="time" name="alarm_time" 
                           value="{{ old('alarm_time', isset($alarm) ? \Carbon\Carbon::parse($alarm->alarm_time)->format('H:i') : '') }}"
                           class="w-full p-3 border rounded-lg" required>
                </div>

                <!-- Days -->
                <div>
                    <label class="block text-gray-700 mb-2">Repeat on Days</label>
                    <div class="grid grid-cols-7 gap-2">
                        @php
                            $days = ['mon' => 'Mon', 'tue' => 'Tue', 'wed' => 'Wed', 
                                     'thu' => 'Thu', 'fri' => 'Fri', 'sat' => 'Sat', 'sun' => 'Sun'];
                            $selectedDays = old('days', isset($alarm) ? $alarm->days : []);
                        @endphp
                        @foreach($days as $key => $label)
                            <label class="flex flex-col items-center p-2 border rounded cursor-pointer hover:bg-gray-50">
                                <input type="checkbox" name="days[]" value="{{ $key }}"
                                       {{ in_array($key, $selectedDays) ? 'checked' : '' }}
                                       class="mr-2">
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Leave empty for everyday</p>
                </div>

                <!-- Video Upload -->
                <div>
                    <label class="block text-gray-700 mb-2">Alarm Video (Optional)</label>
                    <input type="file" name="video" accept="video/*"
                           class="w-full p-3 border rounded-lg">
                    @if(isset($alarm) && $alarm->video_url)
                        <p class="text-sm text-green-600 mt-2">
                            Current: {{ basename($alarm->video_url) }}
                        </p>
                    @endif
                </div>

                <!-- Audio Upload -->
                <div>
                    <label class="block text-gray-700 mb-2">Alarm Sound (Optional)</label>
                    <input type="file" name="audio" accept="audio/*"
                           class="w-full p-3 border rounded-lg">
                    @if(isset($alarm) && $alarm->audio_url)
                        <p class="text-sm text-green-600 mt-2">
                            Current: {{ basename($alarm->audio_url) }}
                        </p>
                    @endif
                </div>

                <!-- Snooze Settings -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold mb-4">Snooze Settings</h3>
                    <div class="flex items-center mb-4">
                        <input type="checkbox" name="snooze_enabled" id="snooze_enabled"
                               {{ old('snooze_enabled', isset($alarm) ? $alarm->snooze_enabled : true) ? 'checked' : '' }}
                               class="mr-2">
                        <label for="snooze_enabled">Enable Snooze</label>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">Snooze Duration (minutes)</label>
                        <input type="number" name="snooze_duration" min="1" max="30"
                               value="{{ old('snooze_duration', $alarm->snooze_duration ?? 5) }}"
                               class="w-32 p-3 border rounded-lg">
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex justify-end space-x-4 pt-6 border-t">
                    <a href="{{ route('alarms.index') }}"
                       class="px-6 py-3 border rounded-lg hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        {{ isset($alarm) ? 'Update Alarm' : 'Create Alarm' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection