    @if($ticket->status == App\Ticket::STATUS_SOLVED)
        <div class="float-right mt-4 mr4 ml-3">
            {{ Form::open(["url" => route('tickets.reopen', $ticket)]) }}
            <button class="button fs1 secondary mt-1"> {{ __('ticket.reopen') }}</button>
            {{ Form::close() }}
        </div>
    @else
        <div class="">
            @include('components.ticket.escalate')
            @include('components.ticket.idea')
            @include('components.ticket.issue')
        </div>
    @endif