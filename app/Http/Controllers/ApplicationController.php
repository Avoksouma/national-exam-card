<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\View\View;
use App\Models\Application;
use App\Models\Combination;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class ApplicationController
 * @package App\Http\Controllers
 * @OA\Tag(
 *     name="apply",
 *     description="Operations related to student application"
 * )
 */
class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['all', 'save']);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/application",
     *     summary="Get a list of all student applications",
     *     tags={"apply"},
     *     @OA\Response(response="200", description="List of student applications"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function all(): JsonResponse
    {
        $applications = Application::paginate(10);
        return response()->json(['applications' => $applications]);
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

    /**
     * @OA\Post(
     *     path="/api/v1/application",
     *     summary="Create a new application",
     *     tags={"apply"},
     *     @OA\Response(response="201", description="Student application created successfully"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="first_name", type="string", example="jane"),
     *             @OA\Property(property="last_name", type="string", example="doe"),
     *             @OA\Property(property="contact_person", type="string", example="guardian"),
     *             @OA\Property(property="contact_details", type="string", example="guardian@email.com"),
     *             @OA\Property(property="combination", type="integer", example=1),
     *             @OA\Property(property="gender", type="string", example="female"),
     *             @OA\Property(property="father", type="string", example="papa"),
     *             @OA\Property(property="mother", type="string", example="mama"),
     *             @OA\Property(property="city", type="string", example="kigali"),
     *             @OA\Property(property="dob", type="string", example="2024-03-15 16:25:04"),
     *             @OA\Property(property="school", type="integer", example=1),
     *         )
     *     )
     * )
     */
    public function save(Request $request): JsonResponse
    {
        $data = $request->json()->all();

        $application = Application::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'school_id' => $data['school'],
            'gender' => $data['gender'],
            'father' => $data['father'],
            'mother' => $data['mother'],
            'city' => $data['city'],
            'status' => $data['status'] ?: 'pending',
            'combination_id' => $data['combination'],
            'nationality' => $data['nationality'],
            'contact_person' => $data['contact_person'],
            'contact_details' => $data['contact_details'],
            'dob' => $data['dob'],
            'description' => $data['description'],
            'user_id' => $data['id'],
        ]);

        return response()->json(['application' => $application]);
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

    /**
     * @OA\Get(
     *     path="/api/v1/application/{id}",
     *     summary="Get a specific student application by ID",
     *     tags={"apply"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the application",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Student application details"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/api/v1/application/{id}",
     *     summary="Update an existing student application",
     *     tags={"apply"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the student application",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Student application updated successfully"),
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

        if ($request['status'] == 'rejected')
            Notification::create([
                'title' => 'Application Rejected',
                'url' => "/application/" . $application->id,
                'content' => 'Your student application has been rejected, we will get in touch to discuss details',
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

    /**
     * @OA\Delete(
     *     path="/api/v1/application/{id}",
     *     summary="Delete a student application by ID",
     *     tags={"apply"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the student application",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Student application deleted successfully"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function destroy(application $application): RedirectResponse
    {
        $application->delete();
        return redirect()->route('application.index');
    }
}
