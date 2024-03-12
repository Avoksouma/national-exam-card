<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class SchoolController
 * @package App\Http\Controllers
 * @OA\Tag(
 *     name="school",
 *     description="Operations related to school"
 * )
 */
class SchoolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['all']);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/school",
     *     summary="Get a list of all schools",
     *     tags={"school"},
     *     @OA\Response(response="200", description="List of schools"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function all(): JsonResponse
    {
        $schools = School::paginate(10);
        return response()->json(['schools' => $schools]);
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

    /**
     * @OA\Post(
     *     path="/api/v1/school",
     *     summary="Create a new school",
     *     tags={"school"},
     *     @OA\Response(response="201", description="School created successfully"),
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

    /**
     * @OA\Get(
     *     path="/api/v1/school/{id}",
     *     summary="Get a specific school by ID",
     *     tags={"school"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the school",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="School details"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function show(Request $request, School $school): View
    {
        return view('school.show', compact('school'));
    }

    public function edit(Request $request, School $school): View
    {
        return view('school.edit', compact('school'));
    }

    /**
     * @OA\Put(
     *     path="/api/v1/school/{id}",
     *     summary="Update an existing school",
     *     tags={"school"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the school",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="School updated successfully"),
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

    /**
     * @OA\Delete(
     *     path="/api/v1/school/{id}",
     *     summary="Delete a school by ID",
     *     tags={"school"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the school",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="School deleted successfully"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function destroy(School $school): RedirectResponse
    {
        $school->delete();
        return redirect()->route('school.index');
    }
}
