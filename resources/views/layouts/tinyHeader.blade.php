<div class="tinyHeader">
    <a href=""><button class="secondary">{{ auth()->user()->name }}</button></a>
    <div class="float-right ml3">
        {{ Form::open(["url" => route('logout')]) }}
        <button>@icon(sign-out)</button>
        {{ Form::close() }}
    </div>
</div>