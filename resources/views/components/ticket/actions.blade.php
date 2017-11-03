@if($ticket->status == App\Ticket::STATUS_SOLVED)
    <div class="float-right mt-1 mr4 ml-3">
        {{ Form::open(["url" => route('tickets.reopen', $ticket)]) }}
        <button class="button fs1 secondary mt-1"> {{ __('ticket.reopen') }}</button>
        {{ Form::close() }}
    </div>
@else
    @include('components.ticket.idea')
    @include('components.ticket.issue')
    @include('components.ticket.escalate')
@endif