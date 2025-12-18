<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AlarmLog;
use Illuminate\Http\Request;

class AlarmLogController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'alarm_id' => 'required|exists:alarms,id',
            'triggered_at' => 'required|date'
        ]);

        $log = AlarmLog::create($validated);

        return response()->json(['success' => true, 'log' => $log]);
    }

    public function stop(Request $request)
    {
        $validated = $request->validate([
            'alarm_id' => 'required|exists:alarms,id'
        ]);

        $log = AlarmLog::where('alarm_id', $validated['alarm_id'])
            ->whereNull('stopped_at')
            ->latest()
            ->first();

        if ($log) {
            $log->update(['stopped_at' => now()]);
        }

        return response()->json(['success' => true]);
    }

    public function snooze(Request $request)
    {
        $validated = $request->validate([
            'alarm_id' => 'required|exists:alarms,id'
        ]);

        $log = AlarmLog::where('alarm_id', $validated['alarm_id'])
            ->whereNull('stopped_at')
            ->latest()
            ->first();

        if ($log) {
            $log->update([
                'was_snoozed' => true,
                'snooze_count' => $log->snooze_count + 1
            ]);
        }

        return response()->json(['success' => true]);
    }
}