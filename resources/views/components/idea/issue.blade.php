@if( config('issues.driver') && count( config('issues.repositories')) > 0)
    @if(auth()->user()->assistant || auth()->user()->admin)
        @if($idea->issue_id)
            <div class="float-right mr4 ml-3">
                <a class="button fs2 secondary" href="{{$idea->issueUrl()}}" target="_blank"> @icon(bug) {{ __('ticket.seeIssue') }}</a>
            </div>
        @elseif($idea->repository)
            <div class="float-right mt-1 mr4 ml-3">
                {{ Form::open(["url" => route('ideas.issue.store', $idea)]) }}
                <button class="secondary dropdown"> @icon(bug) {{ __('ticket.createIssue') }}</button>
                {{ Form::close() }}
            </div>
        @endif
    @endif
@endif
