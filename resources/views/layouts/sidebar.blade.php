<div class="sidebar">
    <h4>Tickets</h4>
    <ul>
        @php $repository = new App\Repositories\TicketsRepository @endphp
        <li class="active">Tickets      <span class="label">{{ $repository->all()->count() }}</span></li>
        <li>Unassigned                  <span class="label">{{ $repository->unassigned()->count() }}</span></li>
        <li>My tickets                  <span class="label">{{ $repository->assignedToMe()->count() }}</span> </li>
        <li>Archive</li>
    </ul>
    <h4>Reports</h4>
    <h4>Leads</h4>
    <h4>Points</h4>
</div>