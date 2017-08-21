<div class="comment">
    <span class="bold"> {{ trans_choice('ticket.attachment',2) }} : </span>
    @include('components.attachments',["attachments" => $attachable->attachments])
    <div class="mt2 hidden" id="upload-attachment">
        {{ Form::open(["url" => route($type.'.attachments.store', $attachable), "files" => true]) }}
        {{ Form::file('attachment') }}
        <button class="secondary"> @icon(upload) {{ __('ticket.uploadAttachment') }}</button>
        {{ Form::close() }}
    </div>
    <div class="mt3 fs2">
        <a id="upload-button" onClick="$('#upload-attachment').toggle(); $('#upload-button').hide()" class="pointer">@icon(upload) {{ __('ticket.uploadAttachment') }}</a>
    </div>
</div>
