<div>
    @foreach($ticket->comments as $comment)
        <div class="comment">
            <span class="date">{{ $comment->created_at->diffForHumans() }}
            ·
            @if($comment->user)
                {{ $comment->user->name }}
            @else
                {{ $ticket->requester->name }}
            @endif
            </span>
            <br>
            {{ $comment->body }}

        </div>
    @endforeach
    <div class="comment">
        <span class="date">{{ $ticket->created_at->diffForHumans() }} · {{ $ticket->requester->name }}</span>
        <br>
        {{ $ticket->body }}
    </div>
</div>