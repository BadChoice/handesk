@extends('layouts.app')
@section('content')

    <div class="description actions comment mb4 mt5">
        <h3 class="ml4 float-left"> {{ trans_choice('setting.setting',2) }}</h3>
    </div>

    <div class="clear-both"></div>


    <div class="description mt4">
        <table class="w50">
            <tr><td>Api token:</td><td> <span id="api-token">{{ env('API_TOKEN') }}</span> <button class="ml2" onclick="copyToClipboard('#api-token')"> @icon(clipboard) Copy to clipboard</button></td></tr>
            {{ Form::open(["url" => route('settings.update',$settings), "method" => "PUT"]) }}
            <tr><td>{{ __("team.slack_webhook_url") }}: </td><td class="w60"><input class="w100" name="slack_webhook_url" value="{{$settings->slack_webhook_url}}"></td></tr>
            <tr><td colspan="2"> <span class="lighter-gray fs2">{{ __('team.slack_webhook_urlDesc') }}</span></td></tr>
            <tr><td><button class="ph4 uppercase">@busy {{ __('ticket.update') }}</button></td></tr>
            {{ Form::close() }}
        </table>
    </div>
@endsection
