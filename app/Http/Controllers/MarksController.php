<?php

namespace App\Http\Controllers;

use App\Models\Marks;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MarksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $marks = Marks::paginate(10);
        return view('marks.index', compact('marks'));
    }

    public function create(): View
    {
        $students = User::where('role', 'student')->all();
        return view('marks.create', compact('students'));
    }

    public function store(Request $request): RedirectResponse
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

    public function show(Request $request, Marks $marks): View
    {
        return view('marks.show', compact('marks'));
    }

    public function edit(Request $request, Marks $marks): View
    {
        $students = User::where('role', 'student')->all();
        return view('marks.edit', compact('marks', 'students'));
    }

    public function update(Request $request, Marks $marks): RedirectResponse
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

    public function destroy(Marks $marks): RedirectResponse
    {
        $marks->delete();
        return redirect()->route('marks.index');
    }
}
