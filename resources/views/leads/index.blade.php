@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>{{ trans_choice('lead.lead',2) }} ( {{ $leads->count() }} )</h3>
    </div>
    @paginator($leads)

    <table class="striped">
        <thead>
        <tr>
            <td class="small"> </td>
            <th> {{ __('team.email') }}</th>
            <th> {{ __('team.team') }}</th>
            <th> {{ __('lead.company') }}</th>
            <th> {{ __('lead.status') }}</th>
            <th> {{ __('ticket.requested') }}</th>
            <th> {{ __('ticket.updated') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($leads as $lead)
            <tr>
                <td> @gravatar( $lead->email ) </td>
                <td> <a href="{{route('leads.show',$lead)}}"> {{ $lead->email }} </a> </td>
                <td> {{ nameOrDash( $lead->team ) }}</td>
                <td> {{ $lead->company }}</td>
                <td> <a href="{{route('leads.show',$lead)}}"> {{ $lead->statusName() }} </a> </td>
                <td> {{ $lead->created_at->diffForHumans() }}</td>
                <td> {{ $lead->updated_at->diffForHumans() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @paginator($leads)
@endsection
