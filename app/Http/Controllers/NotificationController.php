<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $notifications = Notification::paginate(10);
        return view('notification.index', compact('notifications'));
    }

    public function create()
    {
        return view('notification.create');
    }

    public function store(Request $request)
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

    public function show(Request $request, Notification $notification)
    {
        return view('notification.show', compact('notification'));
    }

    public function edit(Request $request, Notification $notification)
    {
        return view('notification.edit', compact('notification'));
    }

    public function update(Request $request, Notification $notification)
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

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return redirect()->route('notification.index');
    }
}
