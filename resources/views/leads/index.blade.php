@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>Tickets ( {{ $leads->count() }} )</h3>
    </div>
    @paginator($leads)

    <table class="striped">
        <thead>
        <tr>
            <th> {{ __('lead.team') }}</th>
            <th> {{ __('lead.email') }}</th>
            <th> {{ __('lead.status') }}</th>
            <th> {{ __('lead.requested') }}</th>
            <th> {{ __('lead.updated') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($leads as $lead)
            <tr>
                <td> {{ nameOrDash($lead->team) }}</td>
                <td> {{ $lead->email }}</td>
                <td> {{ $lead->statusName() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @paginator($leads)
@endsection
