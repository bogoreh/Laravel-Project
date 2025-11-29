<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        return view('calendar');
    }

    public function getEvents()
    {
        $events = Event::all()->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'start' => $event->start_time->toIso8601String(),
                'end' => $event->end_time->toIso8601String(),
                'color' => $event->color,
            ];
        });

        return response()->json($events);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'color' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $event = Event::create($request->all());

        return response()->json([
            'success' => true,
            'event' => $event
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'color' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $event->update($request->all());

        return response()->json([
            'success' => true,
            'event' => $event
        ]);
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json([
            'success' => true
        ]);
    }
}