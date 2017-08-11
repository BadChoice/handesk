<div class="sidebar">
    <img src="{{url("/images/handesk_small.png")}}">
    <h4> @icon(inbox) {{ trans_choice('ticket.ticket',2) }}</h4>
    <ul>
        @php $repository = new App\Repositories\TicketsRepository @endphp
        @include('components.sidebarItem', ["url" => route('tickets.index') . "?all=true",          "title" => __('ticket.open'),       "count" => $repository->all()->count()])
        @include('components.sidebarItem', ["url" => route('tickets.index') . "?unassigned=true",   "title" => __('ticket.unassigned'), "count" => $repository->unassigned()->count()])
        @include('components.sidebarItem', ["url" => route('tickets.index') . "?assigned=true",     "title" => __('ticket.myTickets'), "count" => $repository->assignedToMe()->count()])
        @include('components.sidebarItem', ["url" => route('tickets.index') . "?recent=true",     "title" => __('ticket.recent'), "count" => $repository->recentlyUpdated()->count()])
        @include('components.sidebarItem', ["url" => route('tickets.index') . "?solved=true",     "title" => __('ticket.solved')])
        @include('components.sidebarItem', ["url" => route('tickets.index') . "?closed=true",     "title" => __('ticket.closed')])
    </ul>

    <br>
    <h4> @icon(dot-circle-o) {{ trans_choice('lead.lead',2) }}</h4>
    <ul>
        @php $repository = new App\Repositories\LeadsRepository @endphp
        <li><a href="{{route('leads.index')}}">                 {{ trans_choice('lead.lead',2) }}   </a> @include('components.sidebarLabel', ["count" => $repository->all()->count() ])             </li>
        <li><a href="{{route('leads.index')}}?mine=true">       {{ trans_choice('lead.mine',2) }}  </a>  @include('components.sidebarLabel', ["count" => $repository->assignedToMe()->count() ])    </li>
        <li><a href="{{route('leads.index')}}?completed=true">  {{ trans_choice('lead.completed',2) }}  </a>  </li>
        <li><a href="{{route('leads.index')}}?failed=true">     {{ trans_choice('lead.failed',2) }}  </a>  </li>
    </ul>

    <br>
    <h4> @icon(bar-chart) {{ trans_choice('report.report',2) }}</h4>
    <ul>
        <li><a href="{{route('reports.index')}}">       {{ trans_choice('report.report',2) }}  </a> </li>
    </ul>

    <br>
    <h4> @icon(cog) {{ trans_choice('admin.admin',2) }}</h4>
    <ul>
        <li><a href="{{ route('teams.index') }}">Teams</a></li>
        @if(auth()->user()->admin)
            <li><a href="">Users</a></li>
        @endif
    </ul>
</div>