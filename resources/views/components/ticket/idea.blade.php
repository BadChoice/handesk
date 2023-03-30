@if( config('handesk.roadmap') )
    @if($ticket->getIdeaId())
        <div class="float-right mt-1 mr4 ml-3">
            <a class="button fs2 secondary" href="{{ route('ideas.show',$ticket->getIdeaId()) }}" target="_blank"> @icon(lightbulb-o) {{ __('ticket.seeIdea') }}</a>
        </div>
    @else
    @endif
@endif

