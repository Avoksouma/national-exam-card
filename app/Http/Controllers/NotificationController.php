<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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

    public function destroy(Notification $notification): RedirectResponse
    {
        $notification->delete();
        return redirect()->route('notification.index');
    }
}
