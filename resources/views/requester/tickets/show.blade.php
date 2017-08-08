@extends('layouts.requester')
@section('content')
    <div class="description comment">
        <h3>{{ $ticket->title }}</h3>
        <span class="label ticket-status-{{ $ticket->statusName() }}">{{ $ticket->statusName() }}</span>
        <span class="date">{{  $ticket->created_at->diffForHumans() }} · {{  $ticket->requester->name }}</span>
    </div>

    @if($ticket->status != App\Ticket::STATUS_CLOSED)
        <div class="comment new-comment">
            {{ Form::open(["url" => route("requester.comments.store",$ticket->public_token)]) }}
            <textarea name="body"></textarea>
            <br>
            @if($ticket->status == App\Ticket::STATUS_SOLVED)
                Reopen ? {{ Form::checkbox('reopen') }}
            @else
                Is Solved ? {{ Form::checkbox('solved') }}
            @endif
            <br><br>
            <button class="uppercase"> @busy @icon(comment) {{ __('ticket.comment') }}</button>
            {{ Form::close() }}
        </div>
    @endif
    @include('components.ticketComments')
@endsection
