@if($attachments->count() )
    <div class="bt mt2 pt2">
        @foreach( $attachments as $attachment)
            <a href="">{{ $attachment->path }}</a>
        @endforeach
    </div>
@endif