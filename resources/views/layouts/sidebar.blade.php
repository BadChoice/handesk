<div class="sidebar">
    <img src="{{url("/images/handesk_full.png")}}">
    <h4> @icon(inbox) {{ trans_choice('ticket.ticket',2) }}</h4>
    <ul>
        @php $repository = new App\Repositories\TicketsRepository @endphp
        <li class="active"><a href="{{route('tickets.index')}}">    {{ __('ticket.all') }}     </a> <span class="label">{{ $repository->all()->count() }}           </span></li>
        <li><a href="{{route('tickets.index')}}?unassigned=true">   {{ __('ticket.unassigned') }}  </a> <span class="label">{{ $repository->unassigned()->count() }}    </span></li>
        <li><a href="{{route('tickets.index')}}?assigned=true">     {{ __('ticket.myTickets') }}  </a> <span class="label">{{ $repository->assignedToMe()->count() }}  </span> </li>
        <li><a href="{{route('tickets.index')}}?recent=true">       {{ __('ticket.recent') }}  </a> <span class="label">{{ $repository->recentlyUpdated()->count() }}  </span> </li>
        <li><a href="{{route('tickets.index')}}?closed=true">       {{ __('ticket.archive') }}     </a></li>
    </ul>
    <h4> @icon(dot-circle-o) Leads</h4>
    <ul>
        <li><a href="{{route('tickets.index')}}?recent=true">       {{ __('lead.all') }}  </a> <span class="label">{{ $repository->recentlyUpdated()->count() }}  </span> </li>
        <li><a href="{{route('tickets.index')}}?closed=true">       {{ __('lead.mine') }}  </a></li>
    </ul>
    <h4> @icon(bar-chart) Reports</h4>

    @if(auth()->user()->admin)
        <br>
        <h4> @icon(cog) {{ trans_choice('admin.admin',2) }}</h4>
        <ul>
            <li><a href="{{ route('teams.index') }}">Teams</a></li>
            <li><a href="">Users</a></li>
        </ul>
    @endif
</div>