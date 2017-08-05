@extends('layouts.app')
@section('content')
    <div class="description comment">
        <a href="{{route("home")}}">Tickets</a>
          <h3>{{ $ticket->title }}</h3>
          <span class="label ticket-status-{{ $ticket->statusName() }}">{{ $ticket->statusName() }}</span>
          <span class="date">{{  $ticket->created_at->diffForHumans() }} · {{  $ticket->requester->name }}</span>
          <br>
         {{  implode($ticket->tags->pluck('name')->toArray(), " ") }}
    </div>

    @include('components.ticketActions')

    <div class="comment new-comment">
        {{ Form::open(["url" => route("comments.store",$ticket)]) }}
        <textarea name="body"></textarea>
        <br>
        {{ Form::select("new_status", [
            App\Ticket::STATUS_NEW      => "new",
            App\Ticket::STATUS_OPEN     => "open",
            App\Ticket::STATUS_PENDING  => "pending",
            App\Ticket::STATUS_SOLVED   => "solved",
        ], $ticket->status) }}
        <br><br>
        <button>Comment</button>
        {{ Form::close() }}
    </div>
    @include('components.ticketComments')
@endsection
