@extends('emails.layout')

@section('body')
        <div style="border-bottom:1px solid #efefef; padding-bottom:10px;">
            <span style="font-size:12px">{{ $title }}</span>
        </div>

        <div style="border-bottom:1px solid #efefef; padding-bottom:10px; margin-left:20px; margin-top:20px;">
            {{ $ticket->title }} <br>
            {{__('notification.rateTicketDesc')}}
            <br>
            <a href="{{$url}}?rating=1">1</a>
            <a href="{{$url}}?rating=2">2</a>
            <a href="{{$url}}?rating=3">3</a>
            <a href="{{$url}}?rating=4">4</a>
            <a href="{{$url}}?rating=5">5</a>
        </div>

        <span style="color:white">ticket-id:{{$ticket->id}}.</span>

@endsection