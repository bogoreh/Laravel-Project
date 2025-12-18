<?php

use App\Http\Controllers\AlarmController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// Alarm Routes
Route::resource('alarms', AlarmController::class);
Route::post('/alarms/{alarm}/toggle', [AlarmController::class, 'toggle'])->name('alarms.toggle');

// Note Routes
Route::resource('notes', NoteController::class)->except(['show', 'edit', 'create']);
Route::post('/notes/{note}/toggle-pin', [NoteController::class, 'togglePin'])->name('notes.toggle-pin');

// Alarm Trigger Route
Route::get('/alarm-trigger', function () {
    $now = now();
    $currentTime = $now->format('H:i');
    $currentDay = strtolower($now->format('D'));
    
    $alarms = \App\Models\Alarm::where('is_active', true)
        ->where('alarm_time', $currentTime)
        ->get()
        ->filter(function ($alarm) use ($currentDay) {
            // If no days specified, alarm triggers every day
            if (empty($alarm->days)) {
                return true;
            }
            // Check if today is in the alarm days
            return in_array($currentDay, $alarm->days);
        });
    
    return response()->json([
        'alarms' => $alarms,
        'current_time' => $currentTime
    ]);
});