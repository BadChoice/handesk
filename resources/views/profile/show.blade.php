@extends('layouts.app')
@section('content')
    <div class="description">
        <h3> {{ __('user.profile') }}</h3>
    </div>

    <div class="description actions comment mb4">
        <h3>{{ $user->name }}</h3>
    </div>
    <div class="description">
        {{ Form::open( ["url" => route('profile.update'), 'method' => 'PUT'] ) }}
        <div class="float-left">
            @gravatar($user->email, 90)
        </div>
        <div class="float-left">
            <table class="w-50">
                <tr><td>{{ __('user.name') }}: </td><td class="w-100">{{ Form::text('name', $user->name, ["class" => "w-100"]) }}</td></tr>
                <tr><td>{{ __('user.email') }}: </td><td class="w-100">{{ Form::email('email', $user->email, ["class" => "w-100"]) }}</td></tr>
                <tr><td><button class="ph4 uppercase">  {{ __('ticket.update') }}</button></td></tr>
            </table>
        </div>
        {{ Form::close() }}
    </div>

    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

    <div class="comment actions">
        {{ Form::open( ["url" => route('profile.password')] ) }}
        <table class="w-50 ">
            <tr><td>{{ __('user.oldPassword') }}: </td><td >{{ Form::password('old', ["class" => "w-100"]) }}</td></tr>
            <tr><td>{{ __('user.newPassword') }}: </td><td >{{ Form::password('password', ["class" => "w-100"]) }}</td></tr>
            <tr><td>{{ __('user.confirmPassword') }}: </td><td >{{ Form::password('password_confirmation', ["class" => "w-100"]) }}</td></tr>
            <tr><td><button class="ph4 uppercase">  {{ __('user.changePassword') }}</button></td></tr>
        </table>
        {{ Form::close() }}
    </div>
@endsection
