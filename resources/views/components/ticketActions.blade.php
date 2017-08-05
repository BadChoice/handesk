<div class="actions">
    {{ Form::open(["url" => route('tickets.assign', $ticket)]) }}
    @can("assignToTeam", $ticket)
        Team: {{ Form::select('team_id', createSelectArray( App\Team::all(),true), $ticket->team_id ) }}<br><br>
    @endcan

    @can("assignToTeam", $ticket)
        Assigned: {{ Form::select('user_id', createSelectArray( App\User::all(),true), $ticket->user_id ) }}<br><br>
    @else
        @if($ticket->team)
            Assigned: {{ Form::select('user_id', createSelectArray( $ticket->team->users, true), $ticket->user_id ) }}<br><br>
        @endif
    @endcan
    <button>Update</button>
    {{ Form::close() }}
</div>