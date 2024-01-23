<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $subjects = Subject::paginate(10);
        return view('subject.index', compact('subjects'));
    }

    public function create()
    {
        return view('subject.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'image' => ['image'],
        ]);

        $image = $request->file('image');
        if ($image) {
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public', $image_name);
        }

        Subject::create([
            'name' => $request['name'],
            'image' => $image ? $image_name : null,
            'description' => $request['description'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('subject.index');
    }

    public function show(Request $request, Subject $subject)
    {
        return view('subject.show', compact('subject'));
    }

    public function edit(Request $request, Subject $subject)
    {
        return view('subject.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'image' => ['image'],
        ]);

        $image = $request->file('image');
        if ($image) {
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public', $image_name);
        }

        $subject->update([
            'name' => $request['name'],
            'image' => $image ? $image_name : null,
            'description' => $request['description'],
        ]);

        return redirect()->route('subject.index');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subject.index');
    }
}
