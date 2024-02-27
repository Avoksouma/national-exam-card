<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class PaperController
 * @package App\Http\Controllers
 * @OA\Tag(
 *     name="paper",
 *     description="Operations related to past papers"
 * )
 */
class PaperController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @OA\Get(
     *     path="/paper",
     *     summary="Get a list of all papers",
     *     tags={"paper"},
     *     @OA\Response(response="200", description="List of papers"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function index(): View
    {
        $papers = Paper::paginate(10);
        return view('paper.index', compact('papers'));
    }

    public function create(): View
    {
        $subjects = Subject::all();
        return view('paper.create', compact('subjects'));
    }

    /**
     * @OA\Post(
     *     path="/paper",
     *     summary="Create a new paper",
     *     tags={"paper"},
     *     @OA\Response(response="201", description="Past paper created successfully"),
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
            'subject' => ['required'],
            'document' => ['required'],
        ]);

        $document = $request->file('document');
        if ($document) {
            $document_name = time() . '.' . $document->getClientOriginalExtension();
            $document->storeAs('public', $document_name);
        }

        Paper::create([
            'name' => $request['name'],
            'subject_id' => $request['subject'],
            'document' => $document ? $document_name : null,
            'description' => $request['description'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('paper.index');
    }

    /**
     * @OA\Get(
     *     path="/paper/{id}",
     *     summary="Get a specific paper by ID",
     *     tags={"paper"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the paper",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Past paper details"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function show(Request $request, Paper $paper): View
    {
        return view('paper.show', compact('paper'));
    }

    public function edit(Request $request, Paper $paper): View
    {
        $subjects = Subject::all();
        return view('paper.edit', compact('paper', 'subjects'));
    }

    /**
     * @OA\Put(
     *     path="/paper/{id}",
     *     summary="Update an existing past paper",
     *     tags={"paper"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the past paper",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Past paper updated successfully"),
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
    public function update(Request $request, Paper $paper): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'subject' => ['required'],
        ]);

        $document = $request->file('document');
        if ($document) {
            $document_name = time() . '.' . $document->getClientOriginalExtension();
            $document->storeAs('public', $document_name);
        }

        $paper->update([
            'name' => $request['name'],
            'subject_id' => $request['subject'],
            'document' => $document ? $document_name : null,
            'description' => $request['description'],
        ]);

        return redirect()->route('paper.index');
    }

    /**
     * @OA\Delete(
     *     path="/paper/{id}",
     *     summary="Delete a past paper by ID",
     *     tags={"paper"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the past paper",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Past paper deleted successfully"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function destroy(Paper $paper): RedirectResponse
    {
        $paper->delete();
        return redirect()->route('paper.index');
    }
}
