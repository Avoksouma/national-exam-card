<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaperController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $papers = Paper::paginate(10);
        return view('paper.index', compact('papers'));
    }

    public function create()
    {
        $subjects = Subject::all();
        return view('paper.create', compact('subjects'));
    }

    public function store(Request $request)
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

    public function show(Request $request, Paper $paper)
    {
        return view('paper.show', compact('paper'));
    }

    public function edit(Request $request, Paper $paper)
    {
        $subjects = Subject::all();
        return view('paper.edit', compact('paper', 'subjects'));
    }

    public function update(Request $request, Paper $paper)
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

    public function destroy(Paper $paper)
    {
        $paper->delete();
        return redirect()->route('paper.index');
    }
}
