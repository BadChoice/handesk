@if(auth()->user()->assistant || auth()->user()->admin)
    <div class="float-right mt-2 mr4 ml-3">
    <button class="secondary dropdown"> {{ __('ticket.createIssue') }}</button>
    <ul class="dropdown-container p4">
        @foreach(config('issues.repositories') as $name => $repo)
            <li><a class="pointer" onClick="createIssueToRepo('{{$repo}}')"> {{ $name }}</a></li>
        @endforeach
    </ul>
    {{ Form::open(["url" => route('tickets.issue.store', $ticket), "id" => "issue-form"]) }}
        {{ Form::hidden('repository',"", ["id" => "issue-repository"]) }}
    {{ Form::close() }}
    </div>
@endif

<script>
    function createIssueToRepo(repo){
        $('#issue-repository').val(repo);
        $('#issue-form').submit();
    }
</script>