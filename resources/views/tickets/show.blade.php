@extends('layouts.app')
@section('content')
    <div class="description comment">
        <a href="{{ route('tickets.index') }}">{{ trans_choice('ticket.ticket', 2) }}</a>
        <h3>#{{ $ticket->id }}. {{ $ticket->title }} </h3>
        @busy <span class="label ticket-status-{{ $ticket->statusName() }}">{{ __("ticket." . $ticket->statusName() ) }}</span> &nbsp;
        <span class="date">{{  $ticket->created_at->diffForHumans() }} · {{  $ticket->requester->name }} &lt;{{$ticket->requester->email}}&gt;</span>
        {{--<a class="ml4" title="Public Link" href="{{route('requester.tickets.show',$ticket->public_token)}}"> @icon(globe) </a>--}}


        @include('components.ticket.issue')
        @include('components.ticket.escalate')
        <br>
        @include('components.ticket.merged')
    </div>


    @if( $ticket->canBeEdited() )
        @include('components.assignActions', ["endpoint" => "tickets", "object" => $ticket])
        <div class="comment new-comment">
            {{ Form::open(["url" => route("comments.store", $ticket) , "files" => true, "id" => "comment-form"]) }}
            <textarea name="body"></textarea>
            @include('components.uploadAttachment', ["attachable" => $ticket, "type" => "tickets"])
            <div class="mb1">
                {{ __('ticket.note') }}: {{ Form::checkbox('private') }}
            </div>
            {{ Form::hidden('new_status', $ticket->status, ["id" => "new_status"]) }}
            <button class="mt1 uppercase ph3"> @icon(comment) {{ __('ticket.commentAs') }} {{ $ticket->statusName() }}</button>
            <span class="dropdown button caret-down"> @icon(caret-down) </span>
            <ul class="dropdown-container">
                <li><a class="pointer" onClick="setStatusAndSubmit( {{ App\Ticket::STATUS_OPEN    }} )"><div style="width:10px; height:10px" class="circle inline ticket-status-open mr1"></div> {{ __('ticket.commentAs') }} <b>{{ __("ticket.open") }}   </b> </a></li>
                <li><a class="pointer" onClick="setStatusAndSubmit( {{ App\Ticket::STATUS_PENDING }} )"><div style="width:10px; height:10px" class="circle inline ticket-status-pending mr1"></div> {{ __('ticket.commentAs') }} <b>{{ __("ticket.pending") }}</b> </a></li>
                <li><a class="pointer" onClick="setStatusAndSubmit( {{ App\Ticket::STATUS_SOLVED  }} )"><div style="width:10px; height:10px" class="circle inline ticket-status-solved mr1"></div> {{ __('ticket.commentAs') }} <b>{{ __("ticket.solved") }} </b> </a></li>
            </ul>

            {{ Form::close() }}
        </div>
    @endif
    @include('components.ticketComments', ["comments" => $ticket->commentsAndNotes])
@endsection


@section('scripts')
    @include('components.js.taggableInput', ["el" => "tags", "endpoint" => "tickets", "object" => $ticket])
    <script>
        function setStatusAndSubmit(new_status){
            $("#new_status").val(new_status);
            $("#comment-form").submit();
        }
    </script>
@endsection