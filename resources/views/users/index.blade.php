@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>Agents ( {{ $users->count() }} )</h3>
    </div>


    @paginator($users)
    <table class="striped">
        <thead>
        <tr>
            <th class="small"></th>
            <th> {{ trans_choice('team.name',1) }}          </th>
            <th> {{ trans_choice('team.email',2) }}        </th>
            <th> {{ trans_choice('team.team',1) }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td class="small"> @gravatar($user->email) </td>
                <td> {{ $user->name }}</td>
                <td> {{ $user->email }}</td>
                <td> {{ implode(", ", $user->teams->pluck('name')->toArray() ) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @paginator($users)
@endsection
