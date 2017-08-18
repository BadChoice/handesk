@extends('emails.layout')

@section('body')

    <p> {{ __('lead.todayTasksDesc') }}</p>

    <table class="striped" style="width:100%">
        <thead>
        <tr style="text-align:left">
            <th></th>
            <th> {{ trans_choice('lead.lead',1) }}</th>
            <th> {{ trans_choice('lead.task',1) }}</th>
            <th> {{ trans_choice('ticket.assigned',1) }}</th>
            <th> {{ trans_choice('lead.due',1) }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
            <tr>
                <td> @gravatar($task->lead->email) </td>
                <td><a href="{{route('leads.show',$task->lead)}}">{{ $task->lead->name }}</a></td>
                <td class="@if($task->completed) strike-trough @endif">{{ $task->body }}</td>
                <td>{{ $task->user->name }}</td>
                <td>{{ $task->datetime ? $task->datetime->toDateString() : ""}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection