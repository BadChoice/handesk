@extends('layouts.app')
@section('content')
    <div class="description">
        <h3> <a href="{{route('teams.index')}}"> {{ trans_choice('team.team',2) }}</a> /
        {{ $team->name }} ( {{ $team->members->count() }} )</h3>
    </div>

    @can('administrate', $team)
        <div class="comment actions mb4">
            <h4>{{ __("team.invitationLinkDesc") }}: </h4>
            <div>
                <a href="{{route('membership.store',$team->token)}}"> {{route('membership.store',$team->token)}} </a>
                <div class="hidden" id="register-link-{{$team->id}}"> {{ route('membership.store',$team->token)}} </div>
                <a class="ml2 pointer button" onclick="copyToClipboard('#register-link-{{$team->id}}')">@icon(clipboard) Copy to clipboard</a>
                &nbsp; or
                <div class="hidden" id="register-link2-{{$team->id}}"> {{ route('register') }}?team_token={{$team->token}} </div>
                <a class="ml2 pointer button" onclick="copyToClipboard('#register-link2-{{$team->id}}')">@icon(clipboard) Copy the register link to clipboard</a>
            </div>
        </div>
    @endcan

    <table class="striped">
        <thead>
        <tr>
            <th class="small p2"></th>
            <th> {{ trans_choice('team.member',2) }}        </th>
            <th> {{ trans_choice('team.email',2) }}        </th>
        </tr>
        </thead>
        <tbody>
        @foreach($team->members as $user)
            <tr>
                <td> @include("components.gravatar",["user" => $user]) </td>
                <td> {{ $user->name }}</td>
                <td> <a href="mailto:{{$user->email}}" target="_blank">{{ $user->email }}</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
