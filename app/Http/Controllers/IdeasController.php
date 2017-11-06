<?php

namespace App\Http\Controllers;

use App\Idea;
use App\Rules\ValidRepository;

class IdeasController extends Controller
{
    public function index()
    {
        if (request('pending')) {
            return view('ideas.index', ['ideas' => Idea::pending()->paginate(25)]);
        }

        return view('ideas.index', ['ideas' => Idea::ongoing()->paginate(25)]);
    }

    public function show(Idea $idea)
    {
        $this->authorize('view', $idea);

        return view('ideas.show', ['idea' => $idea]);
    }

    public function edit(Idea $idea)
    {
        $this->authorize('update', $idea);

        return view('ideas.edit', ['idea' => $idea]);
    }

    public function create()
    {
        return view('ideas.create');
    }

    public function update(Idea $idea)
    {
        $this->validate(request(), [
            'title'              => 'required|min:3',
            'body'               => 'required',
            'repository'         => new ValidRepository,
            'development_effort' => 'integer|max:10|min:0',
            'sales_impact'       => 'integer|max:10|min:0',
            'current_impact'     => 'integer|max:10|min:0',
        ]);
        $idea->update([
            'title'              => request('title'),
            'body'               => request('body'),
            'repository'         => request('repository'),
            'status'             => request('status'),
            'due_date'           => request('due_date'),
            'development_effort' => request('development_effort'),
            'sales_impact'       => request('sales_impact'),
            'current_impact'     => request('current_impact'),
        ]);

        return redirect()->route('ideas.index');
    }

    public function store()
    {
        $this->validate(request(), [
            'requester'          => 'required|array',
            'title'              => 'required|min:3',
            'body'               => 'required',
            'repository'         => new ValidRepository,
            'development_effort' => 'integer|max:10|min:0',
            'sales_impact'       => 'integer|max:10|min:0',
            'current_impact'     => 'integer|max:10|min:0',
        ]);
        $idea = Idea::createAndNotify(request('requester'), request('title'), request('body'), request('repository'), request('tags'));
        $idea->update([
            'development_effort' => request('development_effort'),
            'sales_impact'       => request('sales_impact'),
            'current_impact'     => request('current_impact'),
        ]);

        return redirect()->route('ideas.show', $idea);
    }
}
