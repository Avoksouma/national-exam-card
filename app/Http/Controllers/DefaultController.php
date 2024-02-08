<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DefaultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['home', 'about', 'contact', 'license']);
    }

    public function home(): View
    {
        return view('home');
    }

    public function about(): View
    {
        return view('about');
    }

    public function contact(): View
    {
        return view('contact');
    }

    public function license(): View
    {
        return view('license');
    }

    public function dashboard(): View | RedirectResponse
    {
        if (Auth::user()->role == 'student') return redirect()->route('application.index');

        $schools = School::count();
        $applications = Application::count();
        $students = User::where('role', 'student')->count();

        return view('dashboard.index', compact('students', 'schools', 'applications'));
    }

    public function report(): View
    {
        return view('dashboard.report');
    }
}
