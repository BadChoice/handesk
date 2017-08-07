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
            <th> {{ trans_choice('team.team',1) }}</th>
            <th> {{ trans_choice('team.member',2) }}</th>
            <th> {{ trans_choice('team.invitationLink',1) }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($teams as $team)
            <tr>
                <td> {{ $team->name }}</td>
                <td> {{ $team->members->count() }}</td>
                <td> <a href="{{route('membership.store',$team->token)}}"> {{ __("team.invitationLink") }}</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @paginator($teams)
@endsection
