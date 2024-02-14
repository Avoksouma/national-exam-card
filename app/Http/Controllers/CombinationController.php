<?php

namespace App\Http\Controllers;

use App\Models\Combination;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CombinationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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

        Combination::create([
            'name' => $request['name'],
            'image' => $image ? $image_name : null,
            'description' => $request['description'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('combination.index');
    }

    public function show(Request $request, Combination $combination): View
    {
        return view('combination.show', compact('combination'));
    }

    public function edit(Request $request, Combination $combination): View
    {
        return view('combination.edit', compact('combination'));
    }

    public function update(Request $request, Combination $combination): RedirectResponse
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

        $combination->update([
            'name' => $request['name'],
            'image' => $image ? $image_name : null,
            'description' => $request['description'],
        ]);

        return redirect()->route('combination.index');
    }

    public function destroy(Combination $combination): RedirectResponse
    {
        $combination->delete();
        return redirect()->route('combination.index');
    }
}
