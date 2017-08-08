<tr>
        <td>
                <span class="label ticket-status-{{ $ticket->statusName() }}">{{ str_limit($ticket->statusName(),1,'') }}</span>
                &nbsp;
                <a href="{{route('tickets.show',$ticket)}}"> #{{ $ticket->id }}. {{  str_limit($ticket->title,35)  }}</a>
        <td> {{  $ticket->requester->name }}                    </td>
        <td> {{  nameOrDash( $ticket->team ) }}                   </td>
        <td> {{  nameOrDash( $ticket->user ) }}                   </td>
        <td> {{  $ticket->created_at->diffForHumans() }}        </td>
        <td> {{  $ticket->updated_at->diffForHumans() }}        </td>
</tr>