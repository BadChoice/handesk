<?php

namespace App\Http\Controllers;

class MacrosController extends Controller
{
    public function index()
    {
        return view('macros.index', [
            'macros' => collect([]),
        ]);
    }

    public function create()
    {
        return view('macros.create');
    }

    public function store()
    {
        $this->validate(request(), [
            'title' => 'required|min:3',
            'body'  => 'required|min:3',
        ]);

        auth()->user()->macros()->create([
            'title'      => request('title'),
            'body'       => request('body'),
            'assign_id'  => request('user_id'),
            'new_status' => request('status'),
        ])->attachTags(request('tags'));

        return back();
    }
}
