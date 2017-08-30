<div class="tinyHeader">
    <div class="float-left">@include('components.gravatar',["user" => auth()->user() ])</div>
    <a href="{{route('profile.show')}}"><button class="ternary fs2">{{ auth()->user()->name }}</button></a>
    <div class="float-right ml3">
        {{ Form::open(["url" => route('logout')]) }}
        <button class="ternary fs2">@icon(sign-out)</button>
        {{ Form::close() }}
    </div>
</div>