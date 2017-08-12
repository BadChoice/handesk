<div class="tinyHeader">
    <div class="float-left">@gravatar(auth()->user()->email)</div>
    <a href="{{route('profile.show')}}"><button class="secondary fs2">{{ auth()->user()->name }}</button></a>
    <div class="float-right ml3">
        {{ Form::open(["url" => route('logout')]) }}
        <button class="secondary fs2">@icon(sign-out)</button>
        {{ Form::close() }}
    </div>
</div>