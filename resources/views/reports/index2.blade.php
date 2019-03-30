@extends('layouts.app')
@section('content')
    <div class="description mt4">

    </div>
    <div class="grid mt4">
        @foreach($metrics as $metric)
           @include('thrust::metrics.panel', ['metric' => $metric])
        @endforeach
    </div>
@stop

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>
@stop

