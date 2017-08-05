<div class="sidebar">
    <h4>Tickets</h4>
    <ul>
        {{-- TODO: Create a class for getting al those kind of tickets --}}
        @php $teamTickets = auth()->user()->teamsTickets->count() @endphp
        @php $userTickets = auth()->user()->tickets->count() @endphp
        @php $teamTickets = auth()->user()->teamsTickets()->get()->where('user_id',null)->count() @endphp
        <li class="active">Tickets      <span class="label">{{$teamTickets}}</span></li>
        <li>Unassigned                  <span class="label">{{$teamTickets}}</span></li>
        <li>My tickets                  <span class="label">{{$userTickets}}</span> </li>
        <li>Archive</li>
    </ul>
    <h4>Reports</h4>
    <h4>Leads</h4>
    <h4>Points</h4>
</div>