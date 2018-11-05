@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>Tickets ( {{ $tickets->count() }} )</h3>
    </div>

    <div class="m4">
        <a class="button " href="{{ route("tickets.create") }}">@icon(plus) {{ __('ticket.newTicket') }}</a>
        <a class="button secondary" id="mergeButton" title="{{__('ticket.mergeDesc')}}" onclick="mergeTickets()"> {{ __('ticket.merge') }}</a>
        <div class="dropdown-wrapper">
            <span class="dropdown button secondary">Set Status for Tickets @icon(caret-down) </span>
            <ul class="dropdown-container">
                <li>
                    <a class="pointer" onClick="setStatusForMultipleTickets( {{ App\Ticket::STATUS_OPEN    }} )"><div
                                style="width:10px;
                height:10px" class="circle inline ticket-status-open mr1"></div><b>{{ __("ticket.open") }}   </b>
                    </a></li>
                <li><a class="pointer" onClick="setStatusForMultipleTickets( {{ App\Ticket::STATUS_PENDING }} )"><div
                                style="width:10px;
                height:10px" class="circle inline ticket-status-pending mr1"></div><b>{{ __("ticket.pending") }}</b> </a></li>
                <li><a class="pointer" onClick="setStatusForMultipleTickets( {{ App\Ticket::STATUS_SOLVED  }} )"><div
                                style="width:10px;
                height:10px" class="circle inline ticket-status-solved mr1"></div><b>{{ __("ticket.solved") }} </b> </a></li>
            </ul>
        </div>
    </div>

    <div class="float-right mt-5 mr4">
        <input id="searcher" placeholder="{{__('lead.search')}}" class="ml2 shadow-outer-3" style="border-color:#eee">
        <div class="inline ml-4 o60">@icon(search)</div>
    </div>

    <div id="results"></div>
    <div id="all">
        @paginator($tickets)
        @include('tickets.indexTable')
        @paginator($tickets)
    </div>
@endsection

@section('scripts')
    @include('components.js.markMultiple')
    <script>
        $("#searcher").searcher('tickets/search/');
    </script>
@endsection
