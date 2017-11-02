<?php

namespace App\Http\Controllers;

use App\Idea;

class IdeasController extends Controller
{
    public function index()
    {
        return view('ideas.index', ['ideas' => Idea::pending()->paginate(25) ]);
    }

    public function show(Idea $idea)
    {
        $this->authorize('view', $idea);

        return view('ideas.show', ['ticket' => $idea]);
    }

    public function create()
    {
        return view('ideas.create');
    }

    public function store()
    {
        $this->validate(request(), [
            'requester' => 'required|array',
            'title'     => 'required|min:3',
            'body'      => 'required',
        ]);
        $idea = Idea::createAndNotify(request('requester'), request('title'), request('body'), request('tags'));

        return redirect()->route('ideas.show', $idea);
    }
}
