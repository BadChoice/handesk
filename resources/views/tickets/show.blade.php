@extends('layouts.app')
@section('content')
    <div class="description comment">
        <a href="{{ url()->previous() }}">Tickets</a>
        <h3>#{{ $ticket->id }}. {{ $ticket->title }} </h3>
        @busy <span class="label ticket-status-{{ $ticket->statusName() }}">{{ __("ticket.".$ticket->statusName() ) }}</span> &nbsp;
        <span class="date">{{  $ticket->created_at->diffForHumans() }} · {{  $ticket->requester->name }}</span>
        <br>
    </div>

    @if($ticket->status != App\Ticket::STATUS_CLOSED)
        @include('components.ticketActions')

        <div class="comment new-comment">
            {{ Form::open(["url" => route("comments.store",$ticket)]) }}
            <textarea name="body"></textarea>
            <br>
            {{ Form::select("new_status", [
                App\Ticket::STATUS_OPEN     => __("ticket.open"),
                App\Ticket::STATUS_PENDING  => __("ticket.pending"),
                App\Ticket::STATUS_SOLVED   => __("ticket.solved"),
            ], $ticket->status) }}
            <button class="uppercase ph3 ml1"> @icon(comment) {{ __('ticket.comment') }}</button>
            {{ Form::close() }}
        </div>
    @endif
    @include('components.ticketComments')
@endsection


@section('scripts')
    <script>
        $('#tags').tagsInput({
            'height': '20px',
            'width': '100%',
            'onAddTag': onAddTag,
            'onRemoveTag': onRemoveTag,
            'placeholderColor': '#bbb',
            'defaultText': "Add...",
        });

        function onAddTag(tag){
            $.post({
                url: "{{route("tickets.tags.store",$ticket)}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "tag": tag
                }
            });
        }

        function onRemoveTag(tag){
            $.ajax({
                url: "{{ route("tickets.tags.store",$ticket)}}" + "/" + tag,
                method : "DELETE",
                data:{
                    "_token" : "{{ csrf_token() }}",
                }
            });
        }
    </script>
@endsection