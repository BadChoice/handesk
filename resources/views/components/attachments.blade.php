@if($attachments->count() )
    <div class="mt2">
        @foreach( $attachments as $attachment)
            @icon(paperclip)
            <a href="{{ asset("storage/attachments/$attachment->path")}}" target="_blank">{{ $attachment->path }}</a>
        @endforeach
    </div>
@endif