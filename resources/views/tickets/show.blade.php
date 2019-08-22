@extends('layouts.app')
@section('content')
    <div class="description comment">
        <div class="breadcrumb">
            <a href="{{ route('tickets.index') }}">{{ trans_choice('ticket.ticket', 2) }}</a>
        </div>
        <h3>#{{ $ticket->id }}. {{ $ticket->title }} </h3>
        <div class="mb2">
            @include('components.ticket.rating')
        </div>

        @include('components.ticket.actions')
        @include('components.ticket.header')
        @include('components.ticket.merged')
        <br>
    </div>


    @if( $ticket->canBeEdited() )
        @include('components.assignActions', ["endpoint" => "tickets", "object" => $ticket])
        <div class="comment new-comment">
            {{ Form::open(["url" => route("comments.store", $ticket) , "files" => true, "id" => "comment-form"]) }}
            <textarea id="comment-text-area" name="body">@if(auth()->user()->settings->tickets_signature)&#13;&#13;{{ auth()->user()->settings->tickets_signature }}@endif</textarea>
            @include('components.uploadAttachment', ["attachable" => $ticket, "type" => "tickets"])
            {{ Form::hidden('new_status', $ticket->status, ["id" => "new_status"]) }}
            @if($ticket->isEscalated() )
                <button class="mt1 uppercase ph3"> @icon(comment) {{ __('ticket.note') }} </button>
            @else
                <div class="mb1">
                    {{ __('ticket.note') }}: {{ Form::checkbox('private') }}
                </div>
                <button class="mt1 uppercase ph3"> @icon(comment) {{ __('ticket.commentAs') }} {{ $ticket->statusName() }}</button>
                <span class="dropdown button caret-down"> @icon(caret-down) </span>
                <ul class="dropdown-container">
                    <li><a class="pointer" onClick="setStatusAndSubmit( {{ App\Ticket::STATUS_OPEN    }} )"><div style="width:10px; height:10px" class="circle inline ticket-status-open mr1"></div> {{ __('ticket.commentAs') }} <b>{{ __("ticket.open") }}   </b> </a></li>
                    <li><a class="pointer" onClick="setStatusAndSubmit( {{ App\Ticket::STATUS_PENDING }} )"><div style="width:10px; height:10px" class="circle inline ticket-status-pending mr1"></div> {{ __('ticket.commentAs') }} <b>{{ __("ticket.pending") }}</b> </a></li>
                    <li><a class="pointer" onClick="setStatusAndSubmit( {{ App\Ticket::STATUS_SOLVED  }} )"><div style="width:10px; height:10px" class="circle inline ticket-status-solved mr1"></div> {{ __('ticket.commentAs') }} <b>{{ __("ticket.solved") }} </b> </a></li>
                </ul>
            @endif
            {{ Form::close() }}
        </div>
    @endif

    @include('components.ticketComments', ["comments" => $ticket->commentsAndNotesAndEvents()->sortBy('created_at')->reverse() ])
@endsection


@section('scripts')
    @include('components.js.taggableInput', ["el" => "tags", "endpoint" => "tickets", "object" => $ticket])

    <script>
        function setStatusAndSubmit(new_status){
            $("#new_status").val(new_status);
            $("#comment-form").submit();
        }
        $("#comment-text-area").mention({
            delimiter: '@',
            emptyQuery: true,
            typeaheadOpts: {
                items: 10 // Max number of items you want to show
            },
            users: {!! json_encode(App\Services\Mentions::arrayFor(auth()->user())) !!}
        });

    </script>
@endsection