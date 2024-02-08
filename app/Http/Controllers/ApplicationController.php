<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        if (Auth::user()->role == 'student') $applications = Application::where('user_id', Auth::id())->paginate(10);
        else $applications = Application::paginate(10);
        return view('application.index', compact('applications'));
    }

    public function create(): View
    {
        $schools = School::all();
        return view('application.create', compact('schools'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'min:3', 'max:50'],
            'last_name' => ['required', 'min:3', 'max:50'],
            'contact_person' => ['required', 'min:5', 'max:50'],
            'contact_details' => ['required', 'min:5', 'max:50'],
            'gender' => ['required'],
            'school' => ['required'],
            'father' => ['required'],
            'mother' => ['required'],
            'city' => ['required'],
            'dob' => ['required'],
            'image' => ['image'],
        ]);

        $image = $request->file('image');
        if ($image) {
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public', $image_name);
        }

        Application::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'school_id' => $request['school'],
            'gender' => $request['gender'],
            'father' => $request['father'],
            'mother' => $request['mother'],
            'city' => $request['city'],
            'nationality' => $request['nationality'],
            'image' => $image ? $image_name : null,
            'contact_person' => $request['contact_person'],
            'contact_details' => $request['contact_details'],
            'dob' => $request['dob'],
            'description' => $request['description'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('application.index');
    }

    public function show(Request $request, Application $application): View
    {
        return view('application.show', compact('application'));
    }

    public function edit(Request $request, Application $application): View
    {
        $schools = School::all();
        return view('application.edit', compact('application', 'schools'));
    }

    public function update(Request $request, Application $application): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'min:3', 'max:50'],
            'last_name' => ['required', 'min:3', 'max:50'],
            'contact_person' => ['required', 'min:5', 'max:50'],
            'contact_details' => ['required', 'min:5', 'max:50'],
            'school' => ['required'],
            'father' => ['required'],
            'mother' => ['required'],
            'city' => ['required'],
            'dob' => ['required'],
            'image' => ['image'],
        ]);

        $image = $request->file('image');
        if ($image) {
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public', $image_name);
        }

        $application->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'school_id' => $request['school'],
            'gender' => $request['gender'],
            'father' => $request['father'],
            'mother' => $request['mother'],
            'city' => $request['city'],
            'nationality' => $request['nationality'],
            'image' => $image ? $image_name : null,
            'contact_person' => $request['contact_person'],
            'contact_details' => $request['contact_details'],
            'dob' => $request['dob'],
            'description' => $request['description'],
        ]);

        return redirect()->route('application.index');
    }

    public function destroy(application $application): RedirectResponse
    {
        $application->delete();
        return redirect()->route('application.index');
    }
}
