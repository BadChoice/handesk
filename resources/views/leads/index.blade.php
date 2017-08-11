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
            <th> {{ __('lead.company') }}</th>
            <th> {{ __('lead.name') }}</th>
            <th> {{ __('team.email') }}</th>
            <th> {{ trans_choice('ticket.tag',2) }}</th>
            <th> {{ __('team.team') }}</th>
            <th> {{ __('ticket.assigned') }}</th>
            <th> {{ __('lead.status') }}</th>
            <th> {{ __('ticket.requested') }}</th>
            <th> {{ __('ticket.updated') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($leads as $lead)
            <tr>
                <td> @gravatar( $lead->email ) </td>
                <td> <a href="{{route('leads.show',$lead)}}"> {{ $lead->company }} </a></td>
                <td> <a href="{{route('leads.show',$lead)}}"> {{ $lead->name }} </a> </td>
                <td> <a href="mailto:{{$lead->email}}" target="_blank"> {{ $lead->email }} </a> </td>
                <td> {{ $lead->tagsString(", ") }} </td>
                <td> {{ nameOrDash( $lead->team ) }}</td>
                <td> {{ nameOrDash( $lead->user ) }}</td>
                <td> <a class="label lead-status-{{$lead->statusName()}}" href="{{route('leads.show',$lead)}}">
                        {{ __("lead.".$lead->statusName() ) }}
                    </a> </td>
                <td> {{ $lead->created_at->diffForHumans() }}</td>
                <td> {{ $lead->updated_at->diffForHumans() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @paginator($leads)
@endsection
