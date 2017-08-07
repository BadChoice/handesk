<div>
    @foreach($ticket->comments as $comment)
        <div class="comment">
            <div class="date mb0">{{ $comment->created_at->diffForHumans() }}
            ·
            @if($comment->user)
                {{ $comment->user->name }}
            @else
                {{ $ticket->requester->name }}
            @endif
            </div>
            <br>
            {{ $comment->body }}

        </div>
    @endforeach
    <div class="comment">
        <div class="date mb0">{{ $ticket->created_at->diffForHumans() }} · {{ $ticket->requester->name }}</div>
        <br>
        {{ $ticket->body }}
    </div>
</div>