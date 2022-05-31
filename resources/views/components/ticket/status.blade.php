<span class="label ticket-status-{{ $ticket->statusName() }}">{{ link_to_route('tickets.index', \Illuminate\Support\Str::limit(__('ticket.' . $ticket->statusName()), 1, ''), ["status" => $ticket->status]) }}</span>&nbsp;
<span class="label ticket-priority-{{ $ticket->priorityName() }}">{{ link_to_route('tickets.index', \Illuminate\Support\Str::limit(__('ticket.' . $ticket->priorityName()), 1, ''), ["priority" => $ticket->priority]) }}</span>&nbsp;
<span class="label" style="background-color:{{$ticket->type->color ?? "white"}}"> {{ $ticket->type ? strtoupper(\Illuminate\Support\Str::limit($ticket->type->name, 1, '')) : "--" }}</span> &nbsp;
@if ($ticket->isEscalated()) @icon(flag) @endif
@if ($ticket->getIssueId()) @icon(bug) @endif
