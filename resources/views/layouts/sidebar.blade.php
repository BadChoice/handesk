<div class="sidebar" id="sidebar">
    <div class="show-mobile absolute ml2 mt-2 fs3">
        <span class="fs3 white" onclick="toggleSidebar()">X</span>
    </div>
    <img src="{{ url("/images/handesk_small.png") }}">
    @include('layouts.sidebar.tickets')
    @if (config('handesk.leads'))
        @include('layouts.sidebar.leads')
    @endif
    @if (config('handesk.roadmap'))
        @include('layouts.sidebar.roadmap')
    @endif


    <h4> @icon(bar-chart) {{ trans_choice('report.report', 2) }}</h4>
    <ul>
        @include('components.sidebarItem', ["url" => route('reports.index'), "title" => trans_choice('report.report', 2) ])
    </ul>


    <h4> @icon(cog) {{ trans_choice('admin.admin',2) }}</h4>
    <ul>
        @include('components.sidebarItem', ["url" => route('teams.index'),      "title" => trans_choice('team.team',        2) ])
        @if(auth()->user()->admin)
            @include('components.sidebarItem', ["url" => route('users.index'),      "title" => trans_choice('ticket.user',      2) ])
            @include('components.sidebarItem', ["url" => route('settings.edit', 1), "title" => trans_choice('setting.setting',  2) ])
            @include('components.sidebarItem', ["url" => route('ticketTypes.index', 1), "title" => trans_choice('ticket.ticketType',  2) ])
        @endif
    </ul>
    <br>
</div>

<div class="show-mobile absolute ml2 mt3 fs3">
    <span class="fs3 black" onclick="toggleSidebar()">☰</span>
</div>
