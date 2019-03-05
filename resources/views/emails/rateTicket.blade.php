@extends('emails.layout')

<style>
    a{
        text-decoration: none;
    }
    a.ratingStar{
        font-size:24px;
        color: #F6C243;
        margin-right:5px;
    }
</style>

@section('body')
        <div style="border-bottom:1px solid #efefef; padding-bottom:10px;">
            <span style="font-size:12px">{{ $title }}</span>
        </div>

        <div style="border-bottom:1px solid #efefef; padding-bottom:30px; margin-left:20px; margin-top:20px;">
            {{ $ticket->title }} <br><br>
            {{__('notification.rateTicketDesc')}}
            <br><br>
            <a class="ratingStar" href="{{$url}}?rating=1">☆</a>
            <a class="ratingStar" href="{{$url}}?rating=2">☆</a>
            <a class="ratingStar" href="{{$url}}?rating=3">☆</a>
            <a class="ratingStar" href="{{$url}}?rating=4">☆</a>
            <a class="ratingStar" href="{{$url}}?rating=5">☆</a>
        </div>

        <span style="color:white">ticket-id:{{$ticket->id}}.</span>

@endsection