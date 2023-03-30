@extends('layouts.app')
@section('content')
    <div class="description">
        <div class="breadcrumb">
            <a href="{{ url()->previous() }}">Agents</a>
        </div>
    </div>

    <div class="comment description actions mb4">
        <h3>Edit User</h3>
    </div>

    <div class="clear-both"></div>

    <div class="description mt4">
        {{ Form::open(["url" => route('users.update',$user), "method" => "PUT"]) }}
        <table class="maxw600">
            <tr><td>{{ __("user.name") }}: </td><td><input class="w100" name="name" value="{{$team->name}}"></td></tr>
            <tr><td>{{ __("user.email") }}: </td><td><input class="w100" name="email" value="{{$team->email}}"></td></tr>
            <tr><td>{{ __("user.password") }}:</td><td> <input class="w100" name="password" type="password" value="{{$team->password}}"></td></tr>
            <tr><td><button class="ph4 uppercase">@busy {{ __('team.update') }}</button></td></tr>
        </table>
        {{ Form::close() }}
    </div>
@endsection
