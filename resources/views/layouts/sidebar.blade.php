<div class="sidebar">
    <img src="{{url("/images/handesk_small.png")}}">
    <h4> @icon(inbox) {{ trans_choice('ticket.ticket',2) }}</h4>
    <ul>
        @php $repository = new App\Repositories\TicketsRepository @endphp
        <li class="active"><a href="{{route('tickets.index')}}">    {{ __('ticket.open') }}          </a> @include('components.sidebarLabel', ["count" => $repository->all()->count() ]) </li>
        <li><a href="{{route('tickets.index')}}?unassigned=true">   {{ __('ticket.unassigned') }}   </a> @include('components.sidebarLabel', ["count" => $repository->unassigned()->count() ])       </li>
        <li><a href="{{route('tickets.index')}}?assigned=true">     {{ __('ticket.myTickets') }}    </a> @include('components.sidebarLabel', ["count" => $repository->assignedToMe()->count() ])     </li>
        <li><a href="{{route('tickets.index')}}?recent=true">       {{ __('ticket.recent') }}       </a> @include('components.sidebarLabel', ["count" => $repository->recentlyUpdated()->count() ])  </li>
        <li><a href="{{route('tickets.index')}}?solved=true">       {{ __('ticket.solved') }}       </a>  </li>
        <li><a href="{{route('tickets.index')}}?closed=true">       {{ __('ticket.archive') }}     </a></li>
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