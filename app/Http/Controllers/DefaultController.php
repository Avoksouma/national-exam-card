<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DefaultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['home', 'about', 'contact', 'license']);
    }

    public function home()
    {
        return view('home');
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function license()
    {
        return view('license');
    }

    public function dashboard()
    {
        $schools = School::count();
        $students = Student::count();
        $applications = Application::count();

        return view('dashboard.index', compact('students', 'schools', 'applications'));
    }

    public function report()
    {
        return view('dashboard.report');
    }
}
