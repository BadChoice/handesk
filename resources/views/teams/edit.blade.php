@extends('layouts.app')
@section('content')
    <div class="description">
        <div class="breadcrumb">
            <a href="{{ url()->previous() }}">Teams</a>
        </div>
    </div>

    <div class="description actions comment mb4">
        <div class="float-left ml4 mt-2  circle">@gravatar($team->email, 90)</div>
        <h3 class="ml4 float-left"> {{ $team->name }}</h3>
    </div>

    <div class="clear-both"></div>

    <div class="description mt4">
        {{ Form::open(["url" => route('teams.update',$team), "method" => "PUT"]) }}
        <table class="maxw600">
            <tr><td>{{ __("team.name") }}:              </td><td class="w60"><input class="w100" name="name"  value="{{$team->name}}">      </td></tr>
            <tr><td>{{ __("team.email") }}:             </td><td class="w60"><input class="w100" name="email"  value="{{$team->email}}">   </td></tr>
            <tr><td>{{ __("team.slack_webhook_url") }}: </td><td class="w60"><input class="w100" name="slack_webhook_url" value="{{$team->slack_webhook_url}}"></td></tr>
            <tr><td colspan="2"> <span class="lighter-gray fs2">{{ __('team.slack_webhook_urlDesc') }}</span></td></tr>
            <tr><td><button class="ph4 uppercase">@busy {{ __('ticket.update') }}</button></td></tr>
        </table>
        {{ Form::close() }}
    </div>
@endsection
