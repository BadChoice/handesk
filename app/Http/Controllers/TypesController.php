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

    public function store(Type $type)
    {
        $types = Type::paginate(25);

        return view('types.index', ['types' => $types]);
    }

    public function destroy(Type $type)
    { }
}
