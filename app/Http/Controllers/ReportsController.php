<?php

namespace App\Http\Controllers;

use App\Thrust\Metrics\NewTicketsMetric;
use Carbon\Carbon;
use App\Repositories\KpiRepository;

class ReportsController extends Controller
{
    public function index(KpiRepository $repository)
    {
        $startDate = request('startDate') ?: Carbon::now()->startOfMonth();
        $endDate   = request('endDate') ?: Carbon::now()->endOfMonth();

        return view('reports.index', ['repository' => $repository->forDates($startDate, $endDate)]);
    }

    public function index2(){
        $metric = (new NewTicketsMetric)->calculate();
        return view('thrust::metrics.trendMetric', ['metric' => $metric]);
    }
}
