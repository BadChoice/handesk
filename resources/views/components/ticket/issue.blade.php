@if( config('issues.driver') && count( config('issues.repositories')) > 0)
    @if(auth()->user()->assistant || auth()->user()->admin)
        @if($ticket->getIssueId())
            <div class="float-right mt-1 mr4 ml-3">
                <a class="button fs2 secondary" href="{{$ticket->issueUrl()}}" target="_blank"> @icon(bug) {{ __('ticket.seeIssue') }}</a>
            </div>
        @else
            @if($ticket->subject && $ticket->summary)
                <div class="float-right mt-2 mr4 ml-3">
                <button class="secondary dropdown"> @icon(bug) {{ __('ticket.createIssue') }}</button>
                <ul class="dropdown-container p4">
                    @foreach(config('issues.repositories') as $name => $repo)
                        <li><a class="pointer" onClick="createIssueToRepo('{{$repo}}')"> {{ $name }}</a></li>
                    @endforeach
                </ul>
                {{ Form::open(["url" => route('tickets.issue.store', $ticket), "id" => "issue-form"]) }}
                    {{ Form::hidden('repository',"", ["id" => "issue-repository"]) }}
                {{ Form::close() }}
                </div>
            @else
                <div class="float-right mt-2 mr4 ml-3">
                    <button class="secondary"> @icon(bug) {{ __('ticket.needSubject') }}</button>
                </div>
            @endif
        @endif
    @endif

    <script>
        function createIssueToRepo(repo){
            $('#issue-repository').val(repo);
            $('#issue-form').submit();
        }
    </script>
@endif
