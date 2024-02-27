<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class SubjectController
 * @package App\Http\Controllers
 * @OA\Tag(
 *     name="subject",
 *     description="Operations related to subject"
 * )
 */
class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @OA\Get(
     *     path="/subject",
     *     summary="Get a list of all subjects",
     *     tags={"subject"},
     *     @OA\Response(response="200", description="List of subjects"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function index(): View
    {
        $subjects = Subject::paginate(10);
        return view('subject.index', compact('subjects'));
    }

    public function create(): View
    {
        return view('subject.create');
    }

    /**
     * @OA\Post(
     *     path="/subject",
     *     summary="Create a new subject",
     *     tags={"subject"},
     *     @OA\Response(response="201", description="Subject created successfully"),
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
            'image' => ['image'],
        ]);

        $image = $request->file('image');
        if ($image) {
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public', $image_name);
        }

        Subject::create([
            'name' => $request['name'],
            'image' => $image ? $image_name : null,
            'description' => $request['description'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('subject.index');
    }

    /**
     * @OA\Get(
     *     path="/subject/{id}",
     *     summary="Get a specific subject by ID",
     *     tags={"subject"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the subject",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Subject details"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function show(Request $request, Subject $subject): View
    {
        return view('subject.show', compact('subject'));
    }

    public function edit(Request $request, Subject $subject): View
    {
        return view('subject.edit', compact('subject'));
    }

    /**
     * @OA\Put(
     *     path="/subject/{id}",
     *     summary="Update an existing subject",
     *     tags={"subject"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the subject",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Subject updated successfully"),
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
    public function update(Request $request, Subject $subject): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'image' => ['image'],
        ]);

        $image = $request->file('image');
        if ($image) {
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public', $image_name);
        }

        $subject->update([
            'name' => $request['name'],
            'image' => $image ? $image_name : null,
            'description' => $request['description'],
        ]);

        return redirect()->route('subject.index');
    }

    /**
     * @OA\Delete(
     *     path="/subject/{id}",
     *     summary="Delete a subject by ID",
     *     tags={"subject"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the subject",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Subject deleted successfully"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function destroy(Subject $subject): RedirectResponse
    {
        $subject->delete();
        return redirect()->route('subject.index');
    }
}
