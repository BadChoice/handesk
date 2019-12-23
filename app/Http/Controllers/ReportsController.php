<?php

namespace App\Http\Controllers;

use App\Repositories\KpiRepository;
use App\Thrust\Metrics\NewTicketsByMonthMetric;
use App\Thrust\Metrics\NewTicketsMetric;
use App\Thrust\Metrics\RatingAverageMetric;
use App\Thrust\Metrics\SolvedMetric;
use App\Thrust\Metrics\TeamTicketsMetric;
use App\Thrust\Metrics\TicketsCountMetric;
use App\Thrust\Metrics\TicketTypeMetric;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function index(KpiRepository $repository)
    {
        $startDate = request('startDate') ?: Carbon::now()->startOfMonth();
        $endDate   = request('endDate') ?: Carbon::now()->endOfMonth();

        return view('reports.index', ['repository' => $repository->forDates($startDate, $endDate)]);
    }

    public function analytics()
    {
        return view('reports.analytics', [
           'metrics' => [
               (new TicketsCountMetric),
               (new RatingAverageMetric),
               (new SolvedMetric),
               (new NewTicketsMetric),
               (new NewTicketsByMonthMetric),
               (new TicketTypeMetric),
               (new TeamTicketsMetric),
           ],
        ]);
    }
}
