<?php

namespace App\Http\Controllers;

use App\Repositories\KpiRepository;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function index(KpiRepository $repository){
        $startDate  = request('startDate')  ? : Carbon::now()->startOfMonth();
        $endDate    = request('endDate')    ? : Carbon::now()->endOfMonth();
        return view('reports.index', ["repository" => $repository->forDates($startDate,$endDate)]);
    }
}
