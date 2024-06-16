<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Marks;
use App\Models\School;
use App\Models\Subject;
use Illuminate\View\View;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Info(
 *     title="National Exam Card API",
 *     version="0.1.0",
 *     description="The National Exam Card API provides access to student's application for exam card data and process. ",
 * )
 */
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

    public function privacy(): View
    {
        return view('privacy');
    }

    public function dashboard(): View
    {
        $colors = [
            'pending' => 'bg-info',
            'rejected' => 'bg-danger',
            'approved' => 'bg-success',
        ];
        if (Auth::user()->role == 'student') {
            $applications = Application::where('user_id', Auth::id())->limit(10)->get();
            return view('dashboard.index', compact('applications', 'colors'));
        }

        $schools = School::count();
        $applications = Application::count();
        $students = User::where('role', 'student')->count();
        $approved = Application::where('status', 'approved')->count();


        $marks = Marks::select('student_id', DB::raw('SUM(marks) as total_marks'))
            ->groupBy('student_id')->orderBy('total_marks', 'desc')->limit(10)
            ->get();

        $applicants = Application::select('status', DB::raw('COUNT(id) as total'))
            ->groupBy('status')->limit(10)->get();

        return view('dashboard.index', compact('students', 'schools', 'applications', 'marks', 'approved', 'applicants'));
    }

    public function report(Request $request): View | JsonResponse
    {
        $subjects = Subject::all();
        $colors = [
            'pending' => 'bg-info',
            'rejected' => 'bg-danger',
            'approved' => 'bg-success',
        ];
        $tab = $request['tab'] ?: 'year';
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
            });

        $topMarksByStudent = Marks::select('marks.*')
            ->join(DB::raw('(select student_id, MAX(marks) as max_marks from marks group by student_id) as max_marks_table'), function ($join) {
                $join->on('marks.student_id', '=', 'max_marks_table.student_id');
                $join->on('marks.marks', '=', 'max_marks_table.max_marks');
            });

        if ($request['subject'])
            $topMarksByStudent =  $topMarksByStudent->where('marks.subject_id', $request['subject']);

        if ($request['student'])
            $topMarksBySubject = $topMarksBySubject->where('marks.student_id', $request['student']);

        if ($request['year']) {
            $topMarksBySubject = $topMarksBySubject->where('marks.year', $request['year']);
            $topMarksByStudent = $topMarksByStudent->where('marks.year', $request['year']);
        }

        $topMarksBySubject = $topMarksBySubject->get();
        $topMarksByStudent = $topMarksByStudent->get();

        return view('dashboard.report', compact('tab', 'colors', 'subjects', 'students', 'topMarksByYear', 'topMarksBySubject', 'topMarksByStudent'));
    }
}
