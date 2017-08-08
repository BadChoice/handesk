<div class="tinyHeader">
    <a href=""><button class="secondary fs2">{{ auth()->user()->name }}</button></a>
    <div class="float-right ml3">
        {{ Form::open(["url" => route('logout')]) }}
        <button class="secondary fs2">@icon(sign-out)</button>
        {{ Form::close() }}
    </div>
</div>