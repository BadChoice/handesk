@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>Tickets ( {{ $tickets->count() }} )</h3>
    </div>
    <table class="striped">
        <thead>
            <tr>
                <th> {{ __('text.requester') }}</th>
                <th> {{ __('text.subject') }}</th>
                <th> {{ __('text.message') }}</th>
                <th> {{ __('text.team') }}</th>
                <th> {{ __('text.user') }}</th>
                <th> {{ __('text.date') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
                @include('components.ticketHeader', ["ticket" => $ticket])
            @endforeach
        </tbody>
    </table>
@endsection
