@extends('layouts.app')
@section('content')
    <div class="description comment">
        <a href="{{ route('tickets.index') }}">Tickets</a>
    </div>

    {{ Form::open(["url" => route('tickets.merge.store')]) }}
    <input name="ticket_id" />
    <input name="tickets" />
    <button> {{ __('ticket.merge') }}</button>
    {{ Form::close() }}
@endsection
