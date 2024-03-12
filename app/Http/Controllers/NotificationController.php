<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class NotificationController
 * @package App\Http\Controllers
 * @OA\Tag(
 *     name="notification",
 *     description="Operations related to notification"
 * )
 */
class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['all']);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/notification",
     *     summary="Get a list of all notifications",
     *     tags={"notification"},
     *     @OA\Response(response="200", description="List of notifications"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function all(): JsonResponse
    {
        $notifications = Notification::paginate(10);
        return response()->json(['notifications' => $notifications]);
    }

    public function index(): View
    {
        $notifications = Notification::where('user_id', Auth::id())->paginate(10);
        return view('notification.index', compact('notifications'));
    }

    public function create(): View
    {
        return view('notification.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'url' => ['required', 'min:3', 'max:50'],
            'title' => ['required', 'min:3', 'max:50'],
            'content' => ['required', 'min:3'],
        ]);

        Notification::create([
            'url' => $request['url'],
            'title' => $request['title'],
            'content' => $request['content'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('notification.index');
    }

    public function show(Request $request, Notification $notification): View
    {
        return view('notification.show', compact('notification'));
    }

    public function edit(Request $request, Notification $notification): View
    {
        return view('notification.edit', compact('notification'));
    }

    public function update(Request $request, Notification $notification): RedirectResponse
    {
        $request->validate([
            'url' => ['required', 'min:3', 'max:50'],
            'title' => ['required', 'min:3', 'max:50'],
            'content' => ['required', 'min:3'],
        ]);


        $notification->update([
            'url' => $request['url'],
            'title' => $request['title'],
            'content' => $request['content'],
        ]);

        return redirect()->route('notification.index');
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/notification/{id}",
     *     summary="Delete a notification by ID",
     *     tags={"notification"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the notification",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Notification deleted successfully"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function destroy(Notification $notification): RedirectResponse
    {
        $notification->delete();
        return redirect()->route('notification.index');
    }
}
