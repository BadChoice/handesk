@extends('layouts.app')
@section('content')
    <div class="center text-center m5 p4 w40">
        <img src="{{url("/images/handesk_full.png")}}" class="mb4">
        <br>
        <h3 class="fs4"> {{ __('team.invitedTitle', ["team" => strtoupper($team->name)] ) }}</h3>
        <p> {{ __('team.invitedDesc') }}</p>
        {{ Form::open(["url" => route('membership.store', $team->token)]) }}
        <button class="uppercase fs2 p3 mv3">{{ __('team.join') }} <b>{{ $team->name }}</b> {{ trans_choice('team.team',1) }}</button>
        {{ Form::close() }}

        <div class="mt5 bt p3 pt5">
            {{ __('team.register') }}<br>
            <div class="mv3">
                <a  href="{{ route('register') }}?team_token={{$team->token}}" id="register-link">
                    {{ route('register') }}?team_token={{$team->token}}
                </a>
            </div>
            <button class="pointer" onclick="copyToClipboard('#register-link')">@icon(clipboard) Copy to clipboard</button>
        </div>
    </div>
@endsection
