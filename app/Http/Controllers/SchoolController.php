<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SchoolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $schools = School::paginate(10);
        return view('school.index', compact('schools'));
    }

    public function create(): View
    {
        return view('school.create');
    }

    public function store(Request $request): RedirectResponse
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

    public function show(Request $request, School $school): View
    {
        return view('school.show', compact('school'));
    }

    public function edit(Request $request, School $school): View
    {
        return view('school.edit', compact('school'));
    }

    public function update(Request $request, School $school): RedirectResponse
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

    public function destroy(School $school): RedirectResponse
    {
        $school->delete();
        return redirect()->route('school.index');
    }
}
