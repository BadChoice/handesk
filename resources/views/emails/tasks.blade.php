<html>
    <head>
        <style>
            @import url('https://fonts.googleapis.com/css?family=Lato:300,500');
            body {
                margin: 20px;
                font-family: Lato, sans-serif;
                font-size: 14px;
                line-height: 1.42857143;
                font-weight: 100;
            }
        </style>
    </head>
    <body>
    <table class="striped">
        <thead>
        <tr>
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

    </body>
</html>