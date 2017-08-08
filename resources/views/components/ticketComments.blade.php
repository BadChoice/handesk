    @foreach($ticket->comments as $comment)
        <div class="comment">
            <div class="date mb4">
                <div class="float-left mr3">@gravatar($comment->author()->email) </div>
                <div class="pt1">{{ $comment->author()->name }} · {{ $comment->created_at->diffForHumans() }}</div>
            </div>
            <div>{{ $comment->body }}</div>
        </div>
    @endforeach

    <div class="comment">
        <div class="date mb4">
            <div class="float-left mr3">@gravatar($ticket->requester->email) </div>
            <div class="pt1">{{ $ticket->requester->name }} · {{ $ticket->created_at->diffForHumans() }}</div>
        </div>
        <div>{{ $ticket->body }}</div>
    </div>