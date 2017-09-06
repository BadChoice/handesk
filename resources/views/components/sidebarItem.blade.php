<li class="{{ str_contains(request()->fullUrlWithQuery([]), $url) ? "active" : "" }}">
    <a href="{{ $url }}"> {{ $title }}   </a>
    @if( isset($count) )
        @include('components.sidebarLabel', compact("count"))
    @endif
</li>