@extends('layouts.app')
@section('content')
    <div class="center text-center m5 p4 w-40">
        <img src="{{url("/images/handesk.png")}}" class="mb4">
        <br>
        <h3 class="fs4"> {{ __('team.invitedTitle', ["team" => strtoupper($team->name)] ) }}</h3>
        <p> {{ __('team.invitedDesc') }}</p>
        {{ Form::open(["url" => route('membership.store', $team->token)]) }}
        <button class="uppercase fs2 p3 mv3">{{ __('team.join') }} #{{ $team->name }} {{ __('team.team') }}</button>
        {{ Form::close() }}
    </div>
@endsection
