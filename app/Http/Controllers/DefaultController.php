<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\School;
use App\Models\User;
use App\Models\Marks;
use App\Models\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    public function dashboard(): View
    {
        if (Auth::user()->role == 'student') {
            $applications = Application::where('user_id', Auth::id())->limit(10)->get();
            return view('dashboard.index', compact('applications'));
        }

        $schools = School::count();
        $applications = Application::count();
        $students = User::where('role', 'student')->count();

        return view('dashboard.index', compact('students', 'schools', 'applications'));
    }

    public function report(): View | JsonResponse
    {
        $subjects = Subject::all();
        $students = User::where('role', 'student')->get();
        $topMarksByYear = Marks::select('*', DB::raw('MAX(marks) as max_marks'))
            ->groupBy('year')
            ->get();

        $topMarksBySubject = Marks::select('*', DB::raw('MAX(marks) as max_marks'))
            ->groupBy('subject_id')
            ->get();

        $topMarksByStudent = Marks::select('*', DB::raw('MAX(marks) as max_marks'))
            ->groupBy('student_id')
            ->get();

        return view('dashboard.report', compact('subjects', 'students', 'topMarksByYear', 'topMarksBySubject', 'topMarksByStudent'));
    }
}
