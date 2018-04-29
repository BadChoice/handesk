<?php

namespace App\Http\Controllers;

use App\Repositories\LeadsRepository;

class LeadsSearchController extends Controller
{
    public function index(LeadsRepository $repository, $text)
    {
        return view('leads.indexTable', ['leads' => $repository->search($text)->latest('updated_at')->paginate(50)]);
    }
}
