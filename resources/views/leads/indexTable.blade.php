<table class="striped">
    <thead>
    <tr>
        <td class="small"> </td>
        <th> {{ __('lead.company')              }}</th>
        <th> {{ __('lead.name')                 }}</th>
        <th class="hide-mobile"> {{ __('team.email')                }}</th>
        <th class="hide-mobile"> {{ trans_choice('ticket.tag',   2) }}</th>
        <th> {{ trans_choice('team.team',    1) }}</th>
        <th> {{ __('ticket.assigned')           }}</th>
        <th> {{ trans_choice('lead.status',  2) }}</th>
        <th class="hide-mobile"> {{ trans_choice('lead.task',    2) }}</th>
        <th class="hide-mobile"> {{ __('ticket.requested')          }}</th>
        <th class="hide-mobile"> {{ __('ticket.updated')            }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($leads as $lead)
        <tr>
            <td > @gravatar( $lead->email ) </td>
            <td> <a href="{{route('leads.show',$lead)}}"> {{ $lead->company }}          </a></td>
            <td> <a href="{{route('leads.show',$lead)}}"> {{ $lead->name }}             </a> </td>
            <td class="hide-mobile"> <a href="mailto:{{$lead->email}}" target="_blank"> {{ $lead->email }}  </a> </td>
            <td class="hide-mobile"> {{ $lead->tagsString(", ") }}  </td>
            <td> {{ nameOrDash( $lead->team ) }}</td>
            <td> {{ nameOrDash( $lead->user ) }}</td>
            <td> <a class="label lead-status-{{ $lead->statusName() }}" href="{{ route('leads.show', $lead) }}">
                    {{ __("lead." . $lead->statusName() ) }}
                </a>
            </td>
            <td class="hide-mobile">
                @if($lead->uncompletedTasks->count())
                    <span class="label lead-status-failed"> <a href="{{route('leads.tasks.index',$lead)}}" class="white">{{ $lead->uncompletedTasks->count() }}</a></span>
                @endif
            </td>
            <td class="hide-mobile"> {{ $lead->created_at->diffForHumans() }}</td>
            <td class="hide-mobile"> {{ $lead->updated_at->diffForHumans() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
