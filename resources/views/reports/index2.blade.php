@extends('layouts.app')
@section('content')
    <div class="description">

    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>
    <div class="grid">
        @foreach($metrics as $metric)
            <div id="{{$metric->uriKey()}}-div">
                <div class="thrust-panel thrust-trend-metric m2" style="width:402px; height:175px">
                    <h4 class="ml2 lighter-gray">{{ $metric->getTitle() }}</h4><br>
                    <div class="text-center">
                        <i class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop

@section('scripts')
    <script>
        @foreach($metrics as $metric)
            $('#{{$metric->uriKey()}}-div').load("{{route('thrust.metric', base64_encode(get_class($metric)))}}")
        @endforeach
    </script>
@stop