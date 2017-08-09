@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>Reports</h3>
    </div>

    <table class="striped">
        <thead>
            <tr>
                <th></th>
                <th> First Reply Time </th>
                <th> Solve Time </th>
                <th> One touch resolution ratio </th>
                <th> Reopened ratio </th>
            </tr>
        </thead>
        <tr>
            <td> You </td>
            <td>  {{ App\Kpi\FirstReplyKpi::forUser( auth()->user() ) }}</td>
            <td>  {{ App\Kpi\SolveKpi::forUser( auth()->user() ) }}        </td>
            <td>  {{ App\Kpi\OneTouchResolutionKpi::forUser( auth()->user() ) }} %        </td>
            <td>  {{ App\Kpi\ReopenedKpi::forUser( auth()->user() ) }} %        </td>
        </tr>
        <tr>
            <td> You Previous month </td>
            <td>  {{ App\Kpi\FirstReplyKpi::forUser( auth()->user() ) }}</td>
            <td>  {{ App\Kpi\SolveKpi::forUser( auth()->user() ) }}        </td>
            <td>  {{ App\Kpi\OneTouchResolutionKpi::forUser( auth()->user() ) }} %        </td>
            <td>  {{ App\Kpi\ReopenedKpi::forUser( auth()->user() ) }} %        </td>
        </tr>
        <tr>
            <td> Team 1 </td>
            <td>  {{ App\Kpi\FirstReplyKpi::forUser( auth()->user() ) }}</td>
            <td>  {{ App\Kpi\SolveKpi::forUser( auth()->user() ) }}        </td>
            <td>  {{ App\Kpi\OneTouchResolutionKpi::forUser( auth()->user() ) }} %        </td>
            <td>  {{ App\Kpi\ReopenedKpi::forUser( auth()->user() ) }} %        </td>
        </tr>
        <tr>
            <td> Team 2 </td>
            <td>  {{ App\Kpi\FirstReplyKpi::forUser( auth()->user() ) }}</td>
            <td>  {{ App\Kpi\SolveKpi::forUser( auth()->user() ) }}        </td>
            <td>  {{ App\Kpi\OneTouchResolutionKpi::forUser( auth()->user() ) }} %        </td>
            <td>  {{ App\Kpi\ReopenedKpi::forUser( auth()->user() ) }} %        </td>
        </tr>
        <tr>
            <td> All average </td>
            <td>  {{ App\Kpi\FirstReplyKpi::forUser( auth()->user() ) }}</td>
            <td>  {{ App\Kpi\SolveKpi::forUser( auth()->user() ) }}        </td>
            <td>  {{ App\Kpi\OneTouchResolutionKpi::forUser( auth()->user() ) }} %        </td>
            <td>  {{ App\Kpi\ReopenedKpi::forUser( auth()->user() ) }} %        </td>
        </tr>
    </table>

@endsection
