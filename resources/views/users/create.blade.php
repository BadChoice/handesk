@extends('layouts.app')
@section('content')
    <div class="description">
        <a href="{{ url()->previous() }}">Agents</a>
    </div>
    <div class="comment description actions mb4">
        <h3>New User</h3>
    </div>
    {{ Form::open(["url" => route('user.store')]) }}
    <table class="w50">
        <tr><td>{{ __("user.name") }}: </td><td><input class="w100" name="name"  >                         </td></tr>
        <tr><td>{{ __("user.email") }}: </td><td><input class="w100" name="email">                         </td></tr>
        <tr><td>{{ __("user.password") }}:</td><td> <input class="w100" name="password" type="password">  
        </td></tr>
        <tr><td>
        <button class="ph4 uppercase"> @busy {{ __('team.new') }}</button> </td></tr>
    </table>
    {{ Form::close() }}

@endsection
