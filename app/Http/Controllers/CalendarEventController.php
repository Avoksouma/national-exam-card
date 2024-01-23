<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarEventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $calendarEvents = CalendarEvent::paginate(10);
        return view('calendar.index', compact('calendarEvents'));
    }

    public function create()
    {
        return view('calendar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'min:3', 'max:50'],
            'description' => ['required'],
            'time' => ['required'],
        ]);

        CalendarEvent::create([
            'title' => $request['title'],
            'time' => $request['time'],
            'color' => $request['color'],
            'description' => $request['description'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('calendar.index');
    }

    public function show(Request $request, CalendarEvent $calendarEvent)
    {
        return view('calendar.show', compact('calendarEvent'));
    }

    public function edit(Request $request, CalendarEvent $calendarEvent)
    {
        return view('calendar.edit', compact('calendarEvent'));
    }

    public function update(Request $request, CalendarEvent $calendarEvent)
    {
        $request->validate([
            'title' => ['required', 'min:3', 'max:50'],
            'description' => ['required'],
            'time' => ['required'],
        ]);

        $calendarEvent->update([
            'title' => $request['title'],
            'time' => $request['time'],
            'color' => $request['color'],
            'description' => $request['description'],
        ]);

        return redirect()->route('calendar.index');
    }

    public function destroy(CalendarEvent $calendarEvent)
    {
        $calendarEvent->delete();
        return redirect()->route('calendar.index');
    }
}
