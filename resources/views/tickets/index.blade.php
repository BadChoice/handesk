@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>Tickets ( {{ $tickets->count() }} )</h3>
    </div>

    <div class="m4">
        <a class="button " href="{{ route("tickets.create") }}">@icon(plus) New Ticket</a>
    </div>

    @paginator($tickets)

    <table class="striped">
        <thead>
            <tr>
                <th> {{ __('ticket.subject') }}</th>
                <th> {{ __('ticket.requester') }}</th>
                <th> {{ __('ticket.team') }}</th>
                <th> {{ __('ticket.user') }}</th>
                <th> {{ __('ticket.requested') }}</th>
                <th> {{ __('ticket.updated') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
                @include('components.ticketHeader', ["ticket" => $ticket])
            @endforeach
        </tbody>
    </table>
    @paginator($tickets)
@endsection
