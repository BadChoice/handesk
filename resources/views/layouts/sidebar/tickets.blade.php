<h4> @icon(inbox) {{ trans_choice('ticket.ticket', 2) }}</h4>
<ul>
    @php ( $repository = new App\Repositories\TicketsRepository )
    @if( auth()->user()->assistant )
        @include('components.sidebarItem', ["url" => route('tickets.index') . "?escalated=true",    "title" => __('ticket.escalated'),  "count" => $repository->escalated()     ->count()])
    @endif
    @include('components.sidebarItem', ["url" => route('tickets.index') . "?all=true",          "title" => __('ticket.open'),       "count" => $repository->all()               ->count()])
    @include('components.sidebarItem', ["url" => route('tickets.index') . "?unassigned=true",   "title" => __('ticket.unassigned'), "count" => $repository->unassigned()        ->count()])
    @include('components.sidebarItem', ["url" => route('tickets.index') . "?assigned=true",     "title" => __('ticket.myTickets'),  "count" => $repository->assignedToMe()      ->count()])
    @include('components.sidebarItem', ["url" => route('tickets.index') . "?recent=true",       "title" => __('ticket.recent'),     "count" => $repository->recentlyUpdated()   ->count()])
    @include('components.sidebarItem', ["url" => route('tickets.index') . "?solved=true",       "title" => __('ticket.solved')])
    @include('components.sidebarItem', ["url" => route('tickets.index') . "?closed=true",       "title" => __('ticket.closed')])
    @include('components.sidebarItem', ["url" => route('tickets.index') . "?rated=true",       "title" => __('ticket.rated')])
    @include('components.sidebarItem', ["url" => route('requesters.index') ,                    "title" => trans_choice('ticket.requester', 2)])
</ul>