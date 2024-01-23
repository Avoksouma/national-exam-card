<?php

namespace App\Http\Controllers;

use App\Models\Marks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $marks = Marks::paginate(10);
        return view('marks.index', compact('marks'));
    }

    public function create()
    {
        $students = User::where('role', 'student')->all();
        return view('marks.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'marks' => ['required'],
            'semester' => ['required'],
            'year' => ['required'],
            'subject' => ['required'],
            'student' => ['required'],
        ]);

        Marks::create([
            'marks' => $request['marks'],
            'semester' => $request['semester'],
            'year' => $request['year'],
            'subject_id' => $request['subject'],
            'student_id' => $request['student'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('marks.index');
    }

    public function show(Request $request, Marks $marks)
    {
        return view('marks.show', compact('marks'));
    }

    public function edit(Request $request, Marks $marks)
    {
        $students = User::where('role', 'student')->all();
        return view('marks.edit', compact('marks', 'students'));
    }

    public function update(Request $request, Marks $marks)
    {
        $request->validate([
            'marks' => ['required'],
            'semester' => ['required'],
            'year' => ['required'],
            'subject' => ['required'],
            'student' => ['required'],
        ]);

        $marks->update([
            'marks' => $request['marks'],
            'semester' => $request['semester'],
            'year' => $request['year'],
            'subject_id' => $request['subject'],
            'student_id' => $request['student'],
        ]);

        return redirect()->route('marks.index');
    }

    public function destroy(Marks $marks)
    {
        $marks->delete();
        return redirect()->route('marks.index');
    }
}
