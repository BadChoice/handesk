<div class="float-right">
    <div class="mt2 hidden" id="upload-attachment">
        {{ Form::file('attachment', ["id" => "attachment"]) }}
    </div>
    <div class="mt3 fs2">
        <a id="upload-button" onClick="$('#attachment').click(); $('#upload-attachment').toggle(); $('#upload-button').hide()" class="pointer">@icon(paperclip) {{ __('ticket.attachFile') }}</a>
    </div>
</div>
