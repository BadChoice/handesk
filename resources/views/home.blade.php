@extends('layouts.app')
@section('content')
        @foreach($tickets as $ticket)
            @include('components.ticketHeader', ["ticket" => $ticket])
        @endforeach
@endsection
