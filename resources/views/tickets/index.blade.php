@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>Tickets ( {{ $tickets->count() }} )</h3>
    </div>

    <div class="m4">
        <a class="button " href="{{ route("tickets.create") }}">@icon(plus) {{ __('ticket.newTicket') }}</a>
        <a class="button secondary" id="mergeButton" onclick="onMergePressed()"> {{ __('ticket.merge') }}</a>
    </div>

    @paginator($tickets)

    <table class="striped">
        <thead>
            <tr>
                <th> {{ __('ticket.subject') }}</th>
                <th> {{ __('ticket.requester') }}</th>
                <th> {{ __('ticket.team') }}</th>
                <th> {{ __('ticket.assigned') }}</th>
                <th class="hide-mobile"> {{ __('ticket.requested') }}</th>
                <th class="hide-mobile"> {{ __('ticket.updated') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
                @include('components.ticket.ticketHeader', ["ticket" => $ticket])
            @endforeach
        </tbody>
    </table>
    @paginator($tickets)
@endsection

@section('scripts')
    @include('components.js.merge')
@endsection
