<?php

namespace App\Http\Controllers;

use App\Thrust\Metrics\NewTicketsMetric;
use App\Thrust\Metrics\SolvedMetric;
use App\Thrust\Metrics\TeamTicketsMetric;
use App\Thrust\Metrics\TicketTypeMetric;
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

    public function analytics(){
        return view('reports.analytics',[
           'metrics' => [
               (new SolvedMetric),
               (new NewTicketsMetric),
               (new TicketTypeMetric),
               (new TeamTicketsMetric)
           ]
        ]);
    }
}
