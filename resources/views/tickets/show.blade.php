@extends('layouts.app')
@section('content')
    <div class="ticket-header">
        <div class="ticket-requester">  {{  $ticket->requester->name }}                     </div>
        <div class="ticket-assigne">    {{  $ticket->user ? $ticket->user->name : "--" }}   </div>
        <div class="ticket-title">      {{  str_limit($ticket->title,25)  }}                </div>
        <div class="ticket-body">       {{  str_limit($ticket->body , 25) }}                </div>
        <div class="ticket-hour">       {{  $ticket->created_at->diffForHumans() }}         </div>
    </div>

    <div class="comment">
        {{ Form::open(["url" => route("comments.store",$ticket)]) }}
        <textarea name="body"></textarea>
        {{ Form::select("new_status", [
            App\Ticket::STATUS_NEW      => "new",
            App\Ticket::STATUS_OPEN     => "open",
            App\Ticket::STATUS_PENDING  => "pending",
            App\Ticket::STATUS_SOLVED   => "solved",
        ], $ticket->status) }}
        <br>
        <button class="btn btn-primary">Comment</button>
        {{ Form::close() }}
    </div>
    <div>
        @foreach($ticket->comments as $comment)
            <div class="comment">
                {{ $comment->body }}
            </div>
        @endforeach
    </div>
@endsection
