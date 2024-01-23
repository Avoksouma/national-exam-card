<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $messages = Message::paginate(10);
        return view('message.index', compact('messages'));
    }

    public function create()
    {
        $receivers = User::all();
        return view('message.create', compact('receivers'));
    }

    public function store(Request $request)
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

    public function show(Request $request, Message $message)
    {
        return view('message.show', compact('message'));
    }

    public function edit(Request $request, Message $message)
    {
        $receivers = User::all();
        return view('message.edit', compact('message', 'receivers'));
    }

    public function update(Request $request, Message $message)
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

    public function destroy(Message $message)
    {
        $message->delete();
        return redirect()->route('message.index');
    }
}
