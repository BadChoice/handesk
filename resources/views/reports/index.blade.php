@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>Reports</h3>
    </div>

    <div>
        First Reply Time: {{ App\Kpi\FirstReplyKpi::forUser( auth()->user() ) }}
    </div>

    <div>
        Solve Time: {{ App\Kpi\SolveKpi::forUser( auth()->user() ) }}
    </div>

    <div>
        One touch resolution ratio: {{ App\Kpi\OneTouchResolutionKpi::forUser( auth()->user() ) }} %
    </div>

    <div>
        Reopened ratio: {{ App\Kpi\ReopenedKpi::forUser( auth()->user() ) }} %
    </div>

@endsection
