<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $schools = School::paginate(10);
        return view('school.index', compact('schools'));
    }

    public function create()
    {
        return view('school.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'contact' => ['required', 'min:3', 'max:50'],
            'image' => ['image'],
        ]);

        $image = $request->file('image');
        if ($image) {
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public', $image_name);
        }

        School::create([
            'name' => $request['name'],
            'contact' => $request['contact'],
            'image' => $image ? $image_name : null,
            'description' => $request['description'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('school.index');
    }

    public function show(Request $request, School $school)
    {
        return view('school.show', compact('school'));
    }

    public function edit(Request $request, School $school)
    {
        return view('school.edit', compact('school'));
    }

    public function update(Request $request, School $school)
    {
        $request->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'contact' => ['required', 'min:3', 'max:50'],
            'image' => ['image'],
        ]);

        $image = $request->file('image');
        if ($image) {
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public', $image_name);
        }

        $school->update([
            'name' => $request['name'],
            'contact' => $request['contact'],
            'image' => $image ? $image_name : null,
            'description' => $request['description'],
        ]);

        return redirect()->route('school.index');
    }

    public function destroy(School $school)
    {
        $school->delete();
        return redirect()->route('school.index');
    }
}
