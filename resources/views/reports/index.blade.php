@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>Reports</h3>
    </div>

    <table class="striped">
        <thead>
            <tr>
                <th></th>
                <th> {{ trans_choice('ticket.ticket',2) }}          </th>
                <th> {{ __('report.firstReplyTime') }}          </th>
                <th> {{ __('report.solveTime') }}               </th>
                <th> {{ __('report.onTouchResolutionRatio') }}  </th>
                <th> {{ __('report.reopenedRatio') }}           </th>
            </tr>
        </thead>
        <tr>
            <td> You </td>
            <td>  {{ $repository->tickets( auth()->user() ) }}   </td>
            <td>  {{ $repository->firstReplyKpi(auth()->user()) }} ( {{ $repository->average(App\Kpi\Kpi::KPI_FIRST_REPLY, auth()->user()) }} )  </td>
            <td>  {{ $repository->solveKpi(auth()->user()) }}     ( {{ $repository->average(App\Kpi\Kpi::KPI_SOLVED, auth()->user()) }} )</td>
            <td>  {{ $repository->oneTouchResolutionKpi( auth()->user() ) }}    ( {{ $repository->average(App\Kpi\Kpi::KPI_ONE_TOUCH_RESOLUTION, auth()->user()) }} )     </td>
            <td>  {{ $repository->reopenedKpi( auth()->user() ) }}   ( {{ $repository->average(App\Kpi\Kpi::KPI_REOPENED, auth()->user()) }} )      </td>
        </tr>
        @foreach(auth()->user()->teams as $team)
        <tr>
            <td> {{ $team->name }} </td>
            <td>  {{ $repository->tickets( $team ) }}   </td>
            <td>  {{ $repository->firstReplyKpi($team) }} ( {{ $repository->average(App\Kpi\Kpi::KPI_FIRST_REPLY, $team) }} )  </td>
            <td>  {{ $repository->solveKpi($team) }}     ( {{ $repository->average(App\Kpi\Kpi::KPI_SOLVED, $team) }} )</td>
            <td>  {{ $repository->oneTouchResolutionKpi( $team ) }}    ( {{ $repository->average(App\Kpi\Kpi::KPI_ONE_TOUCH_RESOLUTION, $team) }} )     </td>
            <td>  {{ $repository->reopenedKpi( $team ) }}   ( {{ $repository->average(App\Kpi\Kpi::KPI_REOPENED, $team) }} )      </td>
        </tr>
        @endforeach
        <tr>
            <td> All </td>
            <td>  @if(auth()->user()->admin ){{ $repository->tickets( ) }}  @endif </td>
            <td>  {{$repository->firstReplyKpi() }}</td>
            <td>  {{ $repository->solveKpi() }}     </td>
            <td>  {{ $repository->oneTouchResolutionKpi( ) }}         </td>
            <td>  {{ $repository->reopenedKpi(  ) }}         </td>
        </tr>
    </table>

@endsection
