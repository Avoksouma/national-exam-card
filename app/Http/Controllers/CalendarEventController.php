<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Carbon\Carbon;

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
    }

    /**
     * @OA\Get(
     *     path="/api/v1/calendar",
     *     summary="Get a list of all calendar events",
     *     tags={"calendar"},
     *     @OA\Response(response="200", description="List of calendar events"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function all(): JsonResponse
    {
        $userId = Auth::id();
        $calendarEvents = CalendarEvent::select(
            'id',
            'name',
            'color',
            'description',
            'end_date as endDate',
            'is_public as isPublic',
            'start_date as startDate',
        )->where('is_public', true)->orWhere('user_id', $userId)->paginate(100);

        return response()->json(['events' => $calendarEvents]);
    }

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
     *     path="/api/v1/calendar",
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
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'description' => ['required'],
            'startDate' => ['required'],
            'endDate' => ['required'],
            'name' => ['required'],
        ]);

        CalendarEvent::create([
            'name' => $request['name'],
            'color' => $request['color'],
            'end_date' => Carbon::parse($request['endDate']),
            'start_date' => Carbon::parse($request['startDate']),
            'description' => $request['description'],
            'is_public' => in_array(Auth::user()->role, ['staff', 'admin']),
            'user_id' => Auth::id(),
        ]);

        return response()->json(['msg' => 'done']);

        // return redirect()->route('calendar.index');
    }

    /**
     * @OA\Get(
     *     path="/api/v1/calendar/{id}",
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
     *     path="/api/v1/calendar/{id}",
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
    public function update(Request $request, CalendarEvent $calendarEvent): JsonResponse
    {
        $request->validate([
            'description' => ['required'],
            'startDate' => ['required'],
            'endDate' => ['required'],
            'name' => ['required'],
        ]);

        $calendarEvent->update([
            'name' => $request['name'],
            'color' => $request['color'],
            'end_date' => Carbon::parse($request['endDate']),
            'start_date' => Carbon::parse($request['startDate']),
            'description' => $request['description'],
        ]);

        return response()->json(['msg' => 'done']);

        // return redirect()->route('calendar.index');
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/calendar/{id}",
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
    public function destroy(CalendarEvent $calendarEvent): JsonResponse
    {
        $calendarEvent->delete();
        // return redirect()->route('calendar.index');
        return response()->json(['msg' => 'done']);
    }
}
