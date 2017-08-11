@foreach($lead->statusUpdates as $comment)
    <div class="comment">
        <div class="date mb4">
            <div class="float-left mr3">@gravatar($comment->author()->email) </div>
            <div class="pt1"><b>{{ $comment->statusName() }}</b> · {{ nameOrDash($comment->user) }} · {{ $comment->created_at->diffForHumans() }}</div>
        </div>
        <div>{!! nl2br( strip_tags($comment->body)) !!} </div>
    </div>
@endforeach

<div class="comment">
    <div class="date mb4">
        <div class="float-left mr3">@gravatar($lead->requester->email) </div>
        <div class="pt1"> <b>New</b> · {{ $lead->created_at->diffForHumans() }}</div>
    </div>
    <div>{!! nl2br( strip_tags($lead->body)) !!} </div>
</div>