<div class="description actions comment">
    {{ Form::open(["url" => route('tickets.assign', $ticket)]) }}
    <table class="w-50">
    @can("assignToTeam", $ticket)
        <tr><td>Team:</td><td>{{ Form::select('team_id', createSelectArray( App\Team::all(),true), $ticket->team_id ) }}</td><td></td></tr>
    @endcan

    <tr>
        @can("assignToTeam", $ticket)
            <td>Assigned:</td><td>{{ Form::select('user_id', createSelectArray( App\User::all(),true), $ticket->user_id ) }}</td>
        @else
            @if( $ticket->team )
                <td>Assigned:</td><td>{{ Form::select('user_id', createSelectArray( $ticket->team->members, true), $ticket->user_id ) }}</td>
            @endif
            @endcan
        <td> <button class="uppercase"> {{ __('ticket.assign') }}</button></td>
        </tr>
    </table>
    {{ Form::close() }}
</div>