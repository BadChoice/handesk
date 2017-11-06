@if( config('handesk.roadmap') )
    @if($ticket->getIdeaId())
        <div class="float-right mt-1 mr4 ml-3">
            <a class="button fs2 secondary" href="{{route('ideas.show',["id" => $ticket->getIdeaId()])}}" target="_blank"> @icon(lightbulb-o) {{ __('ticket.seeIdea') }}</a>
        </div>
    @else
        <div class="float-right mt-2 mr4 ml-3">
        {{ Form::open(["url" => route('tickets.idea.store', $ticket)]) }}
            <button class="secondary dropdown"> @icon(lightbulb-o) {{ __('ticket.createIdea') }}</button>
        {{ Form::close() }}
        </div>
    @endif
@endif

