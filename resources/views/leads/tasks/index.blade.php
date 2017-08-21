@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>
            <a href="{{ route('leads.index') }}">{{ trans_choice('lead.lead',2) }} </a>/
            <a href="{{ route('leads.show', $lead) }}">{{ $lead->name }}</a> /
            {{trans_choice('lead.task',2)}} ( {{ $lead->tasks->count() }} )
        </h3>
    </div>

    <div class="comment actions">
        {{ Form::open(["url" => route('leads.tasks.store',$lead)]) }}
        <input name="body" placeholder="{{trans_choice('lead.task',1)}}">
        <input type=date name="datetime">
        <button> @icon(plus) {{ __('ticket.new') }}</button>
        {{ Form::close() }}
    </div>

    @paginator($lead->tasks)

    <table class="striped">
        <thead>
        <tr>
            <th> {{ trans_choice('lead.task',1) }}</th>
            <th> {{ trans_choice('ticket.assigned',1) }}</th>
            <th> {{ trans_choice('lead.due',1) }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($lead->tasks as $task)
            <tr>
                <td class="@if($task->completed) strike-trough @endif">{{ $task->body }}</td>
                <td>{{ nameOrDash($task->user)}}</td>
                <td>{{ $task->datetime ? $task->datetime->toDateString() : ""}}</td>
                <td>
                    @if( ! $task->completed)
                        {{ Form::open(["url" => route('tasks.update', $task), 'method' => "PUT"]) }}
                        <input type="hidden" name="completed" value="1">
                        <button class="uppercase"> {{ __('lead.complete') }}</button>
                        {{ Form::close() }}
                    @endif
                </td>
                <td>
                    {{ Form::open(["url" => route('tasks.destroy', $task), 'method' => "DELETE"]) }}
                    <button class="ternary fs3"> @icon(trash) </button>
                    {{ Form::close() }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @paginator($lead->tasks)
@endsection
