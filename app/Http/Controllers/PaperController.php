<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PaperController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

    public function show(Request $request, Paper $paper): View
    {
        return view('paper.show', compact('paper'));
    }

    public function edit(Request $request, Paper $paper): View
    {
        $subjects = Subject::all();
        return view('paper.edit', compact('paper', 'subjects'));
    }

    public function update(Request $request, Paper $paper): RedirectResponse
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

        $paper->update([
            'name' => $request['name'],
            'subject_id' => $request['subject'],
            'document' => $document ? $document_name : null,
            'description' => $request['description'],
        ]);

        return redirect()->route('paper.index');
    }

    public function destroy(Paper $paper): RedirectResponse
    {
        $paper->delete();
        return redirect()->route('paper.index');
    }
}
