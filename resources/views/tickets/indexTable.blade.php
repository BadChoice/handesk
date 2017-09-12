<table class="striped">
    <thead>
    <tr>
        <th> {{ __('ticket.subject') }}</th>
        <th> {{ __('ticket.requester') }}</th>
        <th> {{ __('ticket.team') }}</th>
        <th> {{ __('ticket.assigned') }}</th>
        <th class="hide-mobile"> {{ __('ticket.requested') }}</th>
        <th class="hide-mobile"> {{ __('ticket.updated') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($tickets as $ticket)
        @include('components.ticket.ticketHeader', ["ticket" => $ticket])
    @endforeach
    </tbody>
</table>