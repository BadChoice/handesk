@extends('emails.layout')

@section('body')
        <div style="border-bottom:1px solid #efefef; padding-bottom:10px;">
            <span style="color:#aeaeae; font-size:12px"> {{ config('mail.fetch.replyAboveLine') }}</span><br><br>
            <span style="font-size:12px">{{ $title }}</span>
        </div>

        <div style="border-bottom:1px solid #efefef; padding-bottom:10px; margin-left:20px; margin-top:20px;">
            @if( isset($comment) )
                <b> {{ $comment->author()->name }}</b><br>
                <span style="color:gray">{{ $comment->created_at->toDateTimeString() }}</span><br>
                <p>
                    {!! nl2br( strip_tags($comment->body)) !!}
                </p>
            @else
                <b> {{ $ticket->requester->name }}</b><br>
                <span style="color:gray">{{ $ticket->created_at->toDateTimeString() }}</span><br>
                <p>
                    {!! nl2br( strip_tags($ticket->body)) !!}
                </p>
            @endif
        </div>

        <div style="margin-top:40px">
            Add a comment by replying to this email or <a href="{{$url}}">view the ticket in Handesk</a>
        </div>

        <span style="color:white">ticket-id:{{$ticket->id}}.</span>

@endsection