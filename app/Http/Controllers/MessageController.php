<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $messages = Message::paginate(10);
        return view('message.index', compact('messages'));
    }

    public function create(): View
    {
        $receivers = User::all();
        return view('message.create', compact('receivers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'content' => ['required', 'min:3', 'max:50'],
            'receiver' => ['required'],
        ]);

        Message::create([
            'content' => $request['content'],
            'receiver_id' => $request['receiver'],
            'sender_id' => Auth::id(),
        ]);

        return redirect()->route('message.index');
    }

    public function show(Request $request, Message $message): View
    {
        return view('message.show', compact('message'));
    }

    public function edit(Request $request, Message $message): View
    {
        $receivers = User::all();
        return view('message.edit', compact('message', 'receivers'));
    }

    public function update(Request $request, Message $message): RedirectResponse
    {
        $request->validate([
            'content' => ['required', 'min:3', 'max:50'],
            'receiver' => ['required'],
        ]);


        $message->update([
            'content' => $request['content'],
            'receiver_id' => $request['receiver'],
        ]);

        return redirect()->route('message.index');
    }

    public function destroy(Message $message): RedirectResponse
    {
        $message->delete();
        return redirect()->route('message.index');
    }
}
