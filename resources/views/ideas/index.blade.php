@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>{{ trans_choice('idea.idea' , 2)}} ( {{ $ideas->count() }} )</h3>
    </div>

    <div class="m4">
        <a class="button " href="{{ route("ideas.create") }}">@icon(plus) {{ __('idea.new') }}</a>
    </div>

    @paginator($ideas)
    <table class="striped">
        <thead>
        <tr>
            <th class="small"></th>
            <th> {{ trans_choice('idea.score',1) }}             </th>
            <th> {{ trans_choice('idea.idea',1) }}              </th>
            <th> {{ trans_choice('ticket.requester',1) }}       </th>
            <th> {{ trans_choice('idea.repository',1) }}        </th>
            <th> {{ trans_choice('ticket.tag',2) }}             </th>
            <th> {{ trans_choice('ticket.date',2) }}            </th>
            <th> </th>
        </tr>
        </thead>
        <tbody>
        @foreach($ideas as $idea)
            <tr>
                <td class="small"> @gravatar($idea->requester->email) </td>
                <td><span class="label idea-status-{{ $idea->statusName() }}">{{ __("idea." . $idea->statusName() )[0] }}</span> &nbsp;{{ $idea->score() }}</td>
                <td> <a href="{{route('ideas.show', $idea)}}">{{ $idea->title }}</a></td>
                <td> {{ $idea->requester->name      }}</td>
                <td> {{ $idea->repositoryName() }} </td>
                <td> {{ $idea->tagsString() }}</td>
                <td> {{ $idea->created_at->diffForHumans() }}</td>
                <td>
                    @can('update', $idea)
                        <a href="{{route('ideas.edit', $idea)}}">@icon(pencil)</a>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @paginator($ideas)
@endsection
