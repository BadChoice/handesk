<div class="description actions comment">
    {{ Form::open(["url" => route('tickets.assign', $ticket)]) }}
    <table class="w-50">
    @can("assignToTeam", $ticket)
        <tr><td>Team:</td><td>{{ Form::select('team_id', createSelectArray( App\Team::all(),true), $ticket->team_id ) }}</td></tr>
    @endcan

    @can("assignToTeam", $ticket)
        <tr><td>Assigned:</td><td>{{ Form::select('user_id', createSelectArray( App\User::all(),true), $ticket->user_id ) }}</td></tr>
    @else
        @if($ticket->team)
                <tr><td>Assigned:</td><td>{{ Form::select('user_id', createSelectArray( $ticket->team->users, true), $ticket->user_id ) }}</td></tr>
        @endif
    @endcan
        <tr><td colspan="2">
            <button class="uppercase"> {{ __('ticket.assign') }}</button>
            </td></tr>
    </table>
    {{ Form::close() }}
</div>