@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>
            {{ __('lead.todayTasks')}} ( {{ $tasks->count() }} )
        </h3>
    </div>

    @paginator($tasks)

    <table class="striped">
        <thead>
        <tr>
            <td class="small"></td>
            <th> {{ trans_choice('lead.lead',1) }}</th>
            <th> {{ trans_choice('lead.task',1) }}</th>
            <th> {{ trans_choice('ticket.assigned',1) }}</th>
            <th> {{ trans_choice('lead.due',1) }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach( $tasks as $date => $days )
            <tr> <td colspan="5" class="bg-white mt4"> @if($date != 1) {{ $date }} @endif </td> </tr>
            @foreach( $days as $task )
            <tr>
                <td> @gravatar($task->lead->email) </td>
                <td><a href="{{route('leads.show',$task->lead)}}">{{ $task->lead->name }}</a></td>
                <td class="@if($task->completed) strike-trough @endif">{{ $task->body }}</td>
                <td>{{ $task->user->name }}</td>
                <td>{{ $task->datetime ? $task->datetime->toDateString() : ""}}</td>
                <td>
                    @if( ! $task->completed)
                        {{ Form::open(["url" => route('tasks.update', $task), 'method' => "PUT"]) }}
                        <input type="hidden" name="completed" value="1">
                        <button class="uppercase"> {{ __('lead.complete') }}</button>
                        {{ Form::close() }}
                    @endif
                </td>
            </tr>
        @endforeach
        @endforeach
        </tbody>
    </table>
    @paginator($tasks)
@endsection
