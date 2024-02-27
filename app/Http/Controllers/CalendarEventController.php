<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class CalendarEventController
 * @package App\Http\Controllers
 * @OA\Tag(
 *     name="calendar",
 *     description="Operations related to calendar"
 * )
 */
class CalendarEventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @OA\Get(
     *     path="/calendar",
     *     summary="Get a list of all calendar events",
     *     tags={"calendar"},
     *     @OA\Response(response="200", description="List of calendar events"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function index(): View
    {
        $calendarEvents = CalendarEvent::paginate(10);
        return view('calendar.index', compact('calendarEvents'));
    }

    public function create(): View
    {
        return view('calendar.create');
    }

    /**
     * @OA\Post(
     *     path="/calendar",
     *     summary="Create a new calendar event",
     *     tags={"calendar"},
     *     @OA\Response(response="201", description="Calendar event created successfully"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Sample Title"),
     *             @OA\Property(property="content", type="string", example="Sample content"),
     *             @OA\Property(property="author_id", type="integer", example=1)
     *         )
     *     )
     * )
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'description' => ['required'],
            'start' => ['required'],
            'stop' => ['required'],
        ]);

        CalendarEvent::create([
            'name' => $request['name'],
            'stop' => $request['stop'],
            'start' => $request['start'],
            'color' => $request['color'],
            'description' => $request['description'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('calendar.index');
    }

    /**
     * @OA\Get(
     *     path="/calendar/{id}",
     *     summary="Get a specific calendar event by ID",
     *     tags={"calendar"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the calendar event",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Calendar event details"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function show(Request $request, CalendarEvent $calendarEvent): View
    {
        return view('calendar.show', compact('calendarEvent'));
    }

    public function edit(Request $request, CalendarEvent $calendarEvent): View
    {
        return view('calendar.edit', compact('calendarEvent'));
    }

    /**
     * @OA\Put(
     *     path="/calendar/{id}",
     *     summary="Update an existing calendar event",
     *     tags={"calendar"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the calendar event",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Calendar event updated successfully"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found"),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Updated Title"),
     *             @OA\Property(property="content", type="string", example="Updated content"),
     *             @OA\Property(property="author_id", type="integer", example=1)
     *         )
     *     )
     * )
     */
    public function update(Request $request, CalendarEvent $calendarEvent): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'description' => ['required'],
            'start' => ['required'],
            'stop' => ['required'],
        ]);

        $calendarEvent->update([
            'name' => $request['name'],
            'stop' => $request['stop'],
            'start' => $request['start'],
            'color' => $request['color'],
            'description' => $request['description'],
        ]);

        return redirect()->route('calendar.index');
    }

    /**
     * @OA\Delete(
     *     path="/calendar/{id}",
     *     summary="Delete a calendar event by ID",
     *     tags={"calendar"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the calendar event",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Calendar event deleted successfully"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function destroy(CalendarEvent $calendarEvent): RedirectResponse
    {
        $calendarEvent->delete();
        return redirect()->route('calendar.index');
    }
}
