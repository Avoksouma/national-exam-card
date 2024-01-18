<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $students = Student::paginate(10);
        return view('student.index', compact('students'));
    }

    public function create()
    {
        $schools = School::all();
        return view('student.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'min:3', 'max:50'],
            'last_name' => ['required', 'min:3', 'max:50'],
            'contact_person' => ['required', 'min:5', 'max:50'],
            'contact_details' => ['required', 'min:5', 'max:50'],
            'school' => ['required'],
            'dob' => ['required'],
            'image' => ['image'],
        ]);

        $image = $request->file('image');
        if ($image) {
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public', $image_name);
        }

        Student::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'school_id' => $request['school'],
            'gender' => $request['gender'],
            'nationality' => $request['nationality'],
            'image' => $image ? $image_name : null,
            'contact_person' => $request['contact_person'],
            'contact_details' => $request['contact_details'],
            'dob' => $request['dob'],
            'description' => $request['description'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('student.index');
    }

    public function show(Request $request, Student $student)
    {
        return view('student.show', compact('student'));
    }

    public function edit(Request $request, Student $student)
    {
        $schools = School::all();
        return view('student.edit', compact('student', 'schools'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'first_name' => ['required', 'min:3', 'max:50'],
            'last_name' => ['required', 'min:3', 'max:50'],
            'contact_person' => ['required', 'min:5', 'max:50'],
            'contact_details' => ['required', 'min:5', 'max:50'],
            'school' => ['required'],
            'dob' => ['required'],
            'image' => ['image'],
        ]);

        $image = $request->file('image');
        if ($image) {
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public', $image_name);
        }

        $student->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'school_id' => $request['school'],
            'gender' => $request['gender'],
            'nationality' => $request['nationality'],
            'image' => $image ? $image_name : null,
            'contact_person' => $request['contact_person'],
            'contact_details' => $request['contact_details'],
            'dob' => $request['dob'],
            'description' => $request['description'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('student.index');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('student.index');
    }
}
