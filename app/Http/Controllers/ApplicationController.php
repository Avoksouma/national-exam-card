<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Application;
use App\Models\Combination;
use App\Models\Notification;
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
        $colors = [
            'pending' => 'bg-info',
            'rejected' => 'bg-danger',
            'approved' => 'bg-success',
        ];

        if (Auth::user()->role == 'student') $applications = Application::where('user_id', Auth::id())->paginate(10);
        else $applications = Application::paginate(10);

        return view('application.index', compact('applications', 'colors'));
    }

    public function create(): View
    {
        $schools = School::all();
        $combinations = Combination::all();
        return view('application.create', compact('schools', 'combinations'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'min:3', 'max:50'],
            'last_name' => ['required', 'min:3', 'max:50'],
            'contact_person' => ['required', 'min:3', 'max:50'],
            'contact_details' => ['required', 'min:5', 'max:50'],
            'combination' => ['required'],
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
            'status' => $request['status'] ?: 'pending',
            'combination_id' => $request['combination'],
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
        $colors = [
            'pending' => 'bg-info',
            'rejected' => 'bg-danger',
            'approved' => 'bg-success',
        ];
        return view('application.show', compact('colors', 'application'));
    }

    public function edit(Request $request, Application $application): View
    {
        $schools = School::all();
        $combinations = Combination::all();
        return view('application.edit', compact('application', 'schools', 'combinations'));
    }

    public function update(Request $request, Application $application): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'min:3', 'max:50'],
            'last_name' => ['required', 'min:3', 'max:50'],
            'contact_person' => ['required', 'min:3', 'max:50'],
            'contact_details' => ['required', 'min:5', 'max:50'],
            'combination' => ['required'],
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

        if ($request['status'] == 'approved')
            Notification::create([
                'title' => 'Application Approved',
                'url' => "/application/" . $application->id,
                'content' => 'Your student application has been approved, you are now eligible to do the national exam',
                'user_id' => $application->user_id,
            ]);

        $application->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'school_id' => $request['school'],
            'gender' => $request['gender'],
            'father' => $request['father'],
            'mother' => $request['mother'],
            'city' => $request['city'],
            'status' => $request['status'],
            'combination_id' => $request['combination'],
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
