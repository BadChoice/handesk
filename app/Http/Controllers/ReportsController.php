<?php

namespace App\Http\Controllers;

use App\Repositories\KpiRepository;

class ReportsController extends Controller
{
    public function index(KpiRepository $repository){
        return view('reports.index', ["repository" => $repository]);
    }
}
