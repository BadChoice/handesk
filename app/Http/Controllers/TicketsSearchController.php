<?php

namespace App\Http\Controllers;

use App\Repositories\TicketsRepository;

class TicketsSearchController extends Controller
{
    public function index(TicketsRepository $repository, $text)
    {
        return view('tickets.indexTable', ['tickets' => $repository->search($text)->latest('updated_at')->paginate(50)]);
    }
}
