<div class="description actions comment">
    {{ Form::open(["url" => route('tickets.assign', $ticket)]) }}
    <table class="w-50">
        <tr>
            <td class="small"> {{ trans_choice('ticket.tag',2) }}: </td>
            <td colspan="2"> <input id="tags" name="tags" value="{{$ticket->tagsString()}}"></td>
        </tr>
        @can("assignToTeam", $ticket)
            <tr><td>{{ __('team.team') }}:</td>
            <td>{{ Form::select('team_id', createSelectArray( App\Team::all(),true), $ticket->team_id ) }}</td><td></td></tr>
        @endcan
        <tr>
        @can("assignToTeam", $ticket)
            <td>{{ __('ticket.assigned') }}:</td>
            <td>{{ Form::select('user_id', createSelectArray( App\User::all(),true), $ticket->user_id ) }}</td>
        @else
            @if( $ticket->team )
                <td>{{ __('ticket.assigned') }}</td>
                <td>{{ Form::select('user_id', createSelectArray( $ticket->team->members, true), $ticket->user_id ) }}</td>
            @endif
        @endcan
        <td class="text-right"> <button class="uppercase ph4"> {{ __('ticket.assign') }}</button></td>
        </tr>
    </table>
    {{ Form::close() }}
</div>