    @foreach($comments as $comment)
        <div class="comment @if($comment->private) note @endif">
            <div class="date mb4">
                <div class="float-left mr3">@gravatar($comment->author()->email) </div>
                <div class="pt1">{{ $comment->author()->name }} · {{ $comment->created_at->diffForHumans() }}</div>
            </div>
            <div>
                @if($comment->private) @icon(sticky-note-o) @endif
                {!! nl2br( strip_tags($comment->body)) !!}
            </div>
            @include('components.attachments', ["attachments" => $comment->attachments])
        </div>
    @endforeach

    <div class="comment">
        <div class="date mb4">
            <div class="float-left mr3">@gravatar($ticket->requester->email) </div>
            <div class="pt1">{{ $ticket->requester->name }} · {{ $ticket->created_at->diffForHumans() }}</div>
        </div>
        <div>{!! nl2br( strip_tags($ticket->body)) !!} </div>
        @include('components.attachments', ["attachments" => $ticket->attachments])
    </div>