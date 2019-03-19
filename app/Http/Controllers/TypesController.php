<?php

namespace App\Http\Controllers;

use App\Type;

class TypesController extends Controller
{
    public function index()
    {
        $types = Type::paginate(25);

        return view('types.index', ['types' => $types]);
    }

    public function create()
    {
        return view('types.create');
    }

    public function show(Type $type)
    {
        return view('types.edit', ['type' => $type]);
    }

    public function store()
    {
        $this->authorize('create', Type::class);
        Type::create([
            'name' => request('name'),
            'is_trackable' => request('is_trackable'),
        ]);

        return redirect()->route('types.index');
    }

    public function update(Type $type)
    {
        $type->update([
            'name' => request('name'),
            'is_trackable' => request('is_trackable') ?? 0,

        ]);

        return redirect()->route('types.index');
    }

    public function destroy(Type $type)
    {
        $type->delete();

        return back();
    }
}