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
        $topMarksByYear = Marks::select('marks.*')
            ->join(DB::raw('(select year, MAX(marks) as max_marks from marks group by year) as max_marks_table'), function ($join) {
                $join->on('marks.year', '=', 'max_marks_table.year');
                $join->on('marks.marks', '=', 'max_marks_table.max_marks');
            })
            ->get();

        $topMarksBySubject = Marks::select('marks.*')
            ->join(DB::raw('(select subject_id, MAX(marks) as max_marks from marks group by subject_id) as max_marks_table'), function ($join) {
                $join->on('marks.subject_id', '=', 'max_marks_table.subject_id');
                $join->on('marks.marks', '=', 'max_marks_table.max_marks');
            })
            ->get();

        $topMarksByStudent = Marks::select('marks.*')
            ->join(DB::raw('(select student_id, MAX(marks) as max_marks from marks group by student_id) as max_marks_table'), function ($join) {
                $join->on('marks.student_id', '=', 'max_marks_table.student_id');
                $join->on('marks.marks', '=', 'max_marks_table.max_marks');
            })
            ->get();
        
        return view('dashboard.report', compact('subjects', 'students', 'topMarksByYear', 'topMarksBySubject', 'topMarksByStudent'));
    }
}
