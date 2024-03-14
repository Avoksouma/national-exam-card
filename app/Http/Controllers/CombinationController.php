<?php

namespace App\Http\Controllers;

use App\Models\Combination;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class CombinationController
 * @package App\Http\Controllers
 * @OA\Tag(
 *     name="combination",
 *     description="Operations related to combination"
 * )
 */
class CombinationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['all']);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/combination",
     *     summary="Get a list of all combinations",
     *     tags={"combination"},
     *     @OA\Response(response="200", description="List of combinations"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function all(): JsonResponse
    {
        $combinations = Combination::paginate(10);
        return response()->json(['combinations' => $combinations]);
    }

    public function index(): View
    {
        $combinations = Combination::paginate(10);
        return view('combination.index', compact('combinations'));
    }

    public function create(): View
    {
        return view('combination.create');
    }

    /**
     * @OA\Post(
     *     path="/api/v1/combination",
     *     summary="Create a new combination",
     *     tags={"combination"},
     *     @OA\Response(response="201", description="Combination created successfully"),
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
            'name' => ['required'],
            'image' => ['image'],
        ]);

        $image = $request->file('image');
        if ($image) {
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public', $image_name);
        }

        Combination::create([
            'name' => $request['name'],
            'image' => $image ? $image_name : null,
            'description' => $request['description'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('combination.index');
    }

    /**
     * @OA\Get(
     *     path="/api/v1/combination/{id}",
     *     summary="Get a specific combination by ID",
     *     tags={"combination"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the combination",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Combination details"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function show(Request $request, Combination $combination): View
    {
        return view('combination.show', compact('combination'));
    }

    public function edit(Request $request, Combination $combination): View
    {
        return view('combination.edit', compact('combination'));
    }

    /**
     * @OA\Put(
     *     path="/api/v1/combination/{id}",
     *     summary="Update an existing combination",
     *     tags={"combination"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the combination",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Combination updated successfully"),
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
    public function update(Request $request, Combination $combination): RedirectResponse
    {
        $request->validate([
            'name' => ['required'],
            'image' => ['image'],
        ]);

        $image = $request->file('image');
        if ($image) {
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public', $image_name);
        }

        $combination->update([
            'name' => $request['name'],
            'image' => $image ? $image_name : null,
            'description' => $request['description'],
        ]);

        return redirect()->route('combination.index');
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/combination/{id}",
     *     summary="Delete a combination by ID",
     *     tags={"combination"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the combination",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Combination deleted successfully"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function destroy(Combination $combination): RedirectResponse
    {
        $combination->delete();
        return redirect()->route('combination.index');
    }
}
