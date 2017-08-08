@extends('layouts.app')
@section('content')
    <div class="description comment">
        <a href="{{ url()->previous() }}">Tickets</a>
        <h3>#{{ $ticket->id }}. {{ $ticket->title }} </h3>
        @busy <span class="label ticket-status-{{ $ticket->statusName() }}">{{ __("ticket.".$ticket->statusName() ) }}</span>
        <span class="date">{{  $ticket->created_at->diffForHumans() }} · {{  $ticket->requester->name }}</span>
        <br>
        {{  implode($ticket->tags->pluck('name')->toArray(), " ") }}
    </div>

    @if($ticket->status != App\Ticket::STATUS_CLOSED)
        @include('components.ticketActions')

        <div class="comment new-comment">
            {{ Form::open(["url" => route("comments.store",$ticket)]) }}
            <textarea name="body"></textarea>
            <br>
            {{ Form::select("new_status", [
                App\Ticket::STATUS_OPEN     => __("ticket.open"),
                App\Ticket::STATUS_PENDING  => __("ticket.pending"),
                App\Ticket::STATUS_SOLVED   => __("ticket.solved"),
            ], $ticket->status) }}
            <button class="uppercase"> @icon(comment) {{ __('ticket.comment') }}</button>
            {{ Form::close() }}
        </div>
    @endif
    @include('components.ticketComments')
@endsection


@section('scripts')
    <script>
        $('#tags').tagsInput({
            'height':'10px',
            'width':'100%'
        });
    </script>
@endsection