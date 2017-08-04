@extends('layouts.app')
@section('content')
    <div class="ticket">
        <div class="ticket-requester">  {{  $ticket->requester->name }}                </div>
        <div class="ticket-title">      {{  str_limit($ticket->title,25)  }}           </div>
        <div class="ticket-body">       {{  str_limit($ticket->body , 25) }}           </div>
        <div class="ticket-hour">       {{  $ticket->created_at->diffForHumans() }}    </div>
    </div>

    <div>
        {{ Form::open(["url" => route("comments.store",$ticket)]) }}
        <textarea name="body"></textarea>
        <button></button>
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
