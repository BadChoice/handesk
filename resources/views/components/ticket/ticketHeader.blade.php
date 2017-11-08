<tr>
        <td>
                <input type="checkbox" name="selected[{{$ticket->id}}]" meta:index="{{$ticket->id}}" class="hidden selector">
                <span class="label ticket-status-{{ $ticket->statusName() }}">{{ str_limit(__('ticket.' . $ticket->statusName()), 1, '') }}</span>&nbsp;
                @if( $ticket->isEscalated() ) @icon(flag) @endif
                @if( $ticket->getIssueId() ) @icon(bug) @endif
                <a href="{{ route('tickets.show', $ticket) }}"> #{{ $ticket->id }}. {{  str_limit($ticket->title, 35) }}</a>
        </td>
        <td> {{ $ticket->requester->name            }}</td>
        <td> {{ nameOrDash( $ticket->team )         }}</td>
        <td> {{ nameOrDash( $ticket->user )         }}</td>
        <td class="hide-mobile"> {{ $ticket->created_at->diffForHumans()}}</td>
        <td class="hide-mobile"> {{ $ticket->updated_at->diffForHumans()}}</td>
</tr>