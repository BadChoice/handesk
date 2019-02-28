@extends('layouts.app') 
@section('content')

<div class="description actions comment mt5">
    <h3 class="ml4 float-left mt0"> {{ trans_choice('setting.setting',2) }}</h3>
</div>

<div class="clear-both"></div>

<div class="description mt4">
    <table class="w50">
        <tr>
            <td>Handesk API token:</td>
            <td>
                <span id="api-token">
                    {{ config('handesk.api_token') }}
                </span>
                <button class="ml2" onclick="copyToClipboard('#api-token')"> @icon(clipboard) Copy to clipboard</button>
            </td>
        </tr>
        {{ Form::open(["url" => route('settings.update',$settings), "method" => "PUT"]) }}
        <tr>
            <td>{{ __("team.slack_webhook_url") }}: </td>
            <td class="w60"><input class="w100" name="slack_webhook_url" placeholder="https://hooks.slack.com/services" value="{{$settings->slack_webhook_url}}"></td>
        </tr>
        <tr>
            <td colspan="2"> <span class="lighter-gray fs2">{{ __('team.slack_webhook_urlDesc') }}</span></td>
        </tr>
        <tr>
            <td>Outbound notification status: </td>
            <td class="w60">
                <input class="actionCheckbox" {{ $settings->notification_api_enabled?'checked':'' }} type="checkbox" name="notification_api_enabled"
                value="1" >
            </td>
        </tr>
        <tr>
            <td>Outbound notification endpoint: </td>
            <td class="w60"><input class="w100" name="notification_api_url" placeholder="https://application.io/callbacks" value="{{$settings->notification_api_url}}"></td>
        </tr>
        <tr>
            <td>Outbound notification API token: </td>
            <td class="w60"><input class="w100" name="notification_api_token" placeholder="21kjb242jb123jb5hj123jb" value="{{$settings->notification_api_token}}"></td>
        </tr>
        <tr>
            <td><button class="ph4 uppercase">@busy {{ __('ticket.update') }}</button></td>
        </tr>
        {{ Form::close() }}
    </table>
</div>
@endsection
 
@section('scripts')
<script>
    $.switcher('input[type=checkbox]');

</script>
@endsection