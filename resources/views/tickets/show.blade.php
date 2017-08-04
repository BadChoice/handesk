@extends('layouts.app')
@section('content')
    <div class="description comment">
        <a href="{{route("home")}}">Tickets</a>
          <h3>{{ $ticket->title }}</h3>
          <span class="label ticket-status-{{ $ticket->statusName() }}">{{ str_limit($ticket->statusName(),1,'') }}</span>
          {{  $ticket->created_at->diffForHumans() }}
          ·
          {{  $ticket->requester->name }}
          <br>
          {{  $ticket->user ? $ticket->user->name : "--" }}
    </div>

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
    <div>
        @foreach($ticket->comments as $comment)
            <div class="comment">
                {{ $comment->created_at->diffForHumans() }}
                ·
                @if($comment->user)
                    {{ $comment->user->name }}
                @else
                    {{ $ticket->requester->name }}
                @endif
                <br>
                {{ $comment->body }}

            </div>
        @endforeach
        <div class="comment">
            {{ $ticket->created_at->diffForHumans() }} · {{ $ticket->requester->name }}
            <br>
            {{ $ticket->body }}
        </div>
    </div>
@endsection
