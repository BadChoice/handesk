@if($attachments && $attachments->count() )
    <div class="mt2">
        @foreach( $attachments as $attachment)
            @icon(paperclip)
            <a href="{{ Storage::url("attachments/$attachment->path")}}" target="_blank">{{ $attachment->path }}</a>
        @endforeach
    </div>
@endif