<?php

namespace App\Http\Controllers;

use App\Models\Marks;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class MarksController
 * @package App\Http\Controllers
 * @OA\Tag(
 *     name="marks",
 *     description="Operations related to marks"
 * )
 */
class MarksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @OA\Get(
     *     path="/marks",
     *     summary="Get a list of all marks",
     *     tags={"marks"},
     *     @OA\Response(response="200", description="List of marks"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function index(): View
    {
        if (Auth::user()->role == 'student') $marks = Marks::where('student_id', Auth::id())->paginate(10);
        else $marks = Marks::paginate(10);
        return view('marks.index', compact('marks'));
    }

    public function create(): View
    {
        $subjects = Subject::all();
        $students = User::where('role', 'student')->get();
        return view('marks.create', compact('students', 'subjects'));
    }

    /**
     * @OA\Post(
     *     path="/marks",
     *     summary="Create a new marks",
     *     tags={"marks"},
     *     @OA\Response(response="201", description="Marks created successfully"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Sample Title"),
     *             @OA\Property(property="content", type="string", example="Sample content"),
     *             @OA\Property(property="author_id", type="integer", example=1)
     *         )
     *     )
     * )
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'marks' => ['required'],
            'year' => ['required'],
            'subject' => ['required'],
            'student' => ['required'],
        ]);

        Marks::create([
            'marks' => $request['marks'],
            'year' => $request['year'],
            'subject_id' => $request['subject'],
            'student_id' => $request['student'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('marks.index');
    }

    /**
     * @OA\Get(
     *     path="/marks/{id}",
     *     summary="Get a specific marks by ID",
     *     tags={"marks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the marks",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Marks details"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function show(Request $request, Marks $marks): View
    {
        return view('marks.show', compact('marks'));
    }

    public function edit(Request $request, Marks $mark): View
    {
        $subjects = Subject::all();
        $students = User::where('role', 'student')->get();
        return view('marks.edit', compact('mark', 'students', 'subjects'));
    }

    /**
     * @OA\Put(
     *     path="/marks/{id}",
     *     summary="Update an existing marks",
     *     tags={"marks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the marks",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Marks updated successfully"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found"),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Updated Title"),
     *             @OA\Property(property="content", type="string", example="Updated content"),
     *             @OA\Property(property="author_id", type="integer", example=1)
     *         )
     *     )
     * )
     */
    public function update(Request $request, Marks $mark): RedirectResponse
    {
        $request->validate([
            'marks' => ['required'],
            'year' => ['required'],
            'subject' => ['required'],
            'student' => ['required'],
        ]);

        $mark->update([
            'marks' => $request['marks'],
            'year' => $request['year'],
            'subject_id' => $request['subject'],
            'student_id' => $request['student'],
        ]);

        return redirect()->route('marks.index');
    }

    /**
     * @OA\Delete(
     *     path="/marks/{id}",
     *     summary="Delete a marks by ID",
     *     tags={"marks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the marks",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Marks deleted successfully"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function destroy(Marks $mark): RedirectResponse
    {
        $mark->delete();
        return redirect()->route('marks.index');
    }
}
