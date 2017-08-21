@extends('layouts.app')
@section('content')
    <div class="description comment">
        <a href="{{ route('tickets.index') }}">Tickets</a>
        <h3>#{{ $ticket->id }}. {{ $ticket->title }} </h3>
        @busy <span class="label ticket-status-{{ $ticket->statusName() }}">{{ __("ticket.".$ticket->statusName() ) }}</span> &nbsp;
        <span class="date">{{  $ticket->created_at->diffForHumans() }} · {{  $ticket->requester->name }}</span>
        {{--<a class="ml4" title="Public Link" href="{{route('requester.tickets.show',$ticket->public_token)}}"> @icon(globe) </a>--}}
        <br>
        @include('components.ticket.merged')
    </div>


    @if( $ticket->canBeEdited() )
        @include('components.assignActions', ["endpoint" => "tickets", "object" => $ticket])
        <div class="comment new-comment">
            {{ Form::open(["url" => route("comments.store",$ticket) , "files" => true]) }}
            <textarea name="body"></textarea>
            @include('components.uploadAttachment', ["attachable" => $ticket, "type" => "tickets"])
            <div class="mb1">
                {{ __('ticket.note') }}: {{ Form::checkbox('private') }}
            </div>
            {{ Form::select("new_status", [
                App\Ticket::STATUS_OPEN     => __("ticket.open"),
                App\Ticket::STATUS_PENDING  => __("ticket.pending"),
                App\Ticket::STATUS_SOLVED   => __("ticket.solved"),
            ], $ticket->status) }}
            <button class="uppercase ph3 ml1"> @icon(comment) {{ __('ticket.comment') }}</button>
            {{ Form::close() }}
        </div>
    @endif
    @include('components.ticketComments', ["comments" => $ticket->commentsAndNotes])
@endsection


@section('scripts')
    @include('components.js.taggableInput', ["el" => "tags", "endpoint" => "tickets", "object" => $ticket])
@endsection