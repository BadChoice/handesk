@if($ticket->isEscalated() )
    @if($ticket->status < App\Ticket::STATUS_CLOSED)
        <br>
        <div class="p4 bg-danger white mt-4 mb4 br1 clear-both">
            {{ Form::open(["url" => route('tickets.escalate.destroy', $ticket), "method" => "delete" ]) }}
            @icon(flag) {!! __('ticket.escalatedDesc') !!}
            <button class="primary ml2">@icon(flag) {{ __('ticket.de-escalate') }}</button>
            {{ Form::close() }}
        </div>
    @endif
@else
    <div class="float-right mt-2 mr4">
    {{ Form::open(["url" => route('tickets.escalate.store', $ticket) ]) }}
    <button class="secondary">@icon(flag) {{ __('ticket.escalate') }}</button>
    {{ Form::close() }}
    </div>
@endif
