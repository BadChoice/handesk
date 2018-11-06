@extends('emails.layout')

@section('body')
        <div style="border-bottom:1px solid #efefef; padding-bottom:10px;">
            <span style="font-size:12px">{{ $title }}</span>
        </div>

        <div>
            Ticket has been rated:
            {{ $ticket->title }}<br><br>
            {{ $ticket->rating }}
        </div>


        <span style="color:white">ticket-id:{{$ticket->id}}.</span>

@endsection