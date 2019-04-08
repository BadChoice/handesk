@if($attachments && $attachments->count() )
    <div class="mt2">
        @foreach( $attachments as $attachment)
            @icon(paperclip)
            @if (Storage::getDefaultDriver() == 'google')
                <a href="{{ config('filesystems.disks.google.endpoint') . '/' . config('filesystems.disks.google.bucket') . "/public/attachments/$attachment->path" }}" target="_blank">{{ $attachment->path }}</a>
            @else
                <a href="{{ Storage::url("attachments/$attachment->path")}}" target="_blank">{{ $attachment->path }}</a>
            @endif
        @endforeach
    </div>
@endif