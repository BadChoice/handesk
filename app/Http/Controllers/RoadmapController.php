<?php

namespace App\Http\Controllers;

use App\Idea;

class RoadmapController extends Controller
{
    public function index()
    {
        $ideasQuery = Idea::roadmap();
        if (request('repository')) {
            $ideasQuery->where('repository', request('repository'));
        }

        return view('roadmap.index', ['ideas' => $ideasQuery->get()->groupBy('status')]);
    }
}
