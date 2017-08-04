@extends('layouts.app')
@section('content')
    <div class="ticket">
        <div class="ticket-requester">  {{  $ticket->requester->name }}                </div>
        <div class="ticket-title">      {{  str_limit($ticket->title,25)  }}           </div>
        <div class="ticket-body">       {{  str_limit($ticket->body , 25) }}           </div>
        <div class="ticket-hour">       {{  $ticket->created_at->diffForHumans() }}    </div>
    </div>
@endsection
