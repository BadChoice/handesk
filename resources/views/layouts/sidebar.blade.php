<div class="sidebar">
    <h4> {{ trans_choice('ticket.ticket',2) }}</h4>
    <ul>
        @php $repository = new App\Repositories\TicketsRepository @endphp
        <li class="active"><a href="{{route('tickets.index')}}">    {{ __('ticket.all') }}     </a> <span class="label">{{ $repository->all()->count() }}           </span></li>
        <li><a href="{{route('tickets.index')}}?unassigned=true">   {{ __('ticket.unassigned') }}  </a> <span class="label">{{ $repository->unassigned()->count() }}    </span></li>
        <li><a href="{{route('tickets.index')}}?assigned=true">     {{ __('ticket.myTickets') }}  </a> <span class="label">{{ $repository->assignedToMe()->count() }}  </span> </li>
        <li><a href="{{route('tickets.index')}}?closed=true">       {{ __('ticket.archive') }}     </a></li>
    </ul>
    <h4>Reports</h4>
    <h4>Leads</h4>
    <h4>Points</h4>
</div>