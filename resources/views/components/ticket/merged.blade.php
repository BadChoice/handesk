@if(count($ticket->mergedTickets))
    <div class="mt4 mb3">
        {{ __('ticket.merged') }} :
        @foreach($ticket->mergedTickets as $merged)
            <a href="{{route("tickets.show", $merged)}}"> #{{ $merged->id }} </a>
        @endforeach
    </div>
@endif