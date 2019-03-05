@if($ticket->rating)
    @for($i = 0; $i < 5; $i++)
        @if($ticket->rating > $i)
            @icon(star)
        @else
            @icon(star-o)
        @endif
    @endfor
@endif