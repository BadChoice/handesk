@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>Teams ( {{ $teams->count() }} )</h3>
    </div>

    @if(auth()->user()->admin)
        <div class="m4">
            <a class="button " href="{{ route("teams.create") }}">@icon(plus) New Team</a>
        </div>
    @endif

    @paginator($teams)
    <table class="striped">
        <thead>
        <tr>
            <th class="small"></th>
            <th> {{ trans_choice('team.team',1) }}          </th>
            <th> {{ trans_choice('team.member',2) }}        </th>
            <th> {{ trans_choice('team.invitationLink',1) }}</th>
            <th>                                            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($teams as $team)
            <tr>
                <td class="small"> @gravatar($team->email) </td>
                <td> {{ $team->name }}</td>
                <td> {{ $team->members->count() }}</td>
                @can('administrate', $team)
                    <td>
                        <a href="{{route('membership.store',$team->token)}}"> {{ __("team.invitationLink") }}</a>
                        <div class="hidden" id="register-link-{{$team->id}}"> {{ route('membership.store',$team->token)}} </div>
                        <a class="ml2 pointer" onclick="copyToClipboard('#register-link-{{$team->id}}')">@icon(clipboard)</a>
                    </td>
                @else
                    <td></td>
                @endcan
                <th> <a href="{{route('tickets.index')}}?team={{$team->id}}"> @icon(inbox) </a></th>
                <th> <a href="{{route('leads.index')}}?team={{$team->id}}"> @icon(dot-circle-o) </a></th>
                @can('administrate', $team)
                    <th> <a href="{{route('teams.edit',$team)}}"> @icon(pencil) </a></th>
                @endcan
            </tr>
        @endforeach
        </tbody>
    </table>
    @paginator($teams)
@endsection
