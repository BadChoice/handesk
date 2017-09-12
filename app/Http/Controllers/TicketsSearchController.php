<?php

namespace App\Http\Controllers;

use App\Lead;
use App\Repositories\LeadsRepository;
use App\Repositories\TicketsRepository;

class TicketsSearchController extends Controller
{
    public function index(TicketsRepository $repository, $text){
        return view('tickets.indexTable', [ "tickets" => $repository->search($text)->latest()->get() ]);
    }
}
