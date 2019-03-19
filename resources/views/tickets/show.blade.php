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
    <div id="ticket-info" class="float-left">
        @busy <span class="label ticket-status-{{ $ticket->statusName() }}">{{ __("ticket." . $ticket->statusName() ) }}</span>        &nbsp; @busy <span class="label ticket-priority-{{ $ticket->priorityName() }}">{{ __("ticket." . $ticket->priorityName() ) }}</span>        &nbsp;
        <span class="date">{{  $ticket->created_at->diffForHumans() }} · {{  $ticket->requester->name }} &lt;{{$ticket->requester->email}}&gt;</span>
        <button class="ternary" onClick="$('#ticket-info').hide(); $('#ticket-edit').show()">@icon(pencil)</button> {{--
        <a class="ml4" title="Public Link" href="{{route('requester.tickets.show',$ticket->public_token)}}"> @icon(globe) </a>--}}
    </div>
    <div id="ticket-edit" class="hidden" class="float-left">
        {{ Form::open(["url" => route("tickets.update", $ticket) ,"method" => "PUT"]) }}
        <!-- TODO: make this pull from the database. -->

        <select name="priority">
            <option value="{{\App\Ticket::PRIORITY_LOW}}"  @if($ticket->priority == App\Ticket::PRIORITY_LOW) selected @endif         >{{ __("ticket.low") }}</option>
            <option value="{{\App\Ticket::PRIORITY_NORMAL}}"  @if($ticket->priority == App\Ticket::PRIORITY_NORMAL) selected @endif   >{{ __("ticket.normal") }}</option>
            <option value="{{\App\Ticket::PRIORITY_HIGH}}"  @if($ticket->priority == App\Ticket::PRIORITY_HIGH) selected @endif       >{{ __("ticket.high") }}</option>
            <option value="{{\App\Ticket::PRIORITY_BLOCKER}}"  @if($ticket->priority == App\Ticket::PRIORITY_BLOCKER) selected @endif >{{ __("ticket.blocker") }}</option>
        </select>
        <select name="type_id">
            @foreach ($types as $type)
            <option value="{{ $type->id}}" {{ $type->id==$ticket->type_id?'selected':'' }} >{{ $type->name }}</option>                
            @endforeach
        </select>
        <input name="requester[name]" value="{{  $ticket->requester->name }}">
        <input name="requester[email]" value="{{$ticket->requester->email}}">
        <button> {{ __("ticket.update")}} </button> {{ Form::close() }}
    </div>
    @include('components.ticket.actions')
    <br>
    @include('components.ticket.merged')
</div>
@if( $ticket->canTrackTime() )
<div class="description actions comment">
    <table class="w50">
        <tr>
            <td class="small"> {{ __("type.isTrackable") }}:</td>
            <td colspan="2">{!! makeTimeTrackableField($ticket) !!}</td>
        </tr>
    </table>
</div>
@endif @if( $ticket->canBeEdited() )
    @include('components.assignActions', ["endpoint" => "tickets", "object" => $ticket])
<div class="comment new-comment">
    {{ Form::open(["url" => route("comments.store", $ticket) , "files" => true, "id" => "comment-form"]) }}
    <textarea id="comment-text-area" name="body"></textarea>
    @include('components.uploadAttachment', ["attachable" => $ticket,
    "type" => "tickets"]) {{ Form::hidden('new_status', $ticket->status, ["id" => "new_status"]) }} @if($ticket->isEscalated()
    )
    <button class="mt1 uppercase ph3"> @icon(comment) {{ __('ticket.note') }} </button> @else
    <div class="mb1">
        {{ __('ticket.note') }}: {{ Form::checkbox('private') }}
    </div>
    <button class="mt1 uppercase ph3"> @icon(comment) {{ __('ticket.commentAs') }} {{ $ticket->statusName() }}</button>
    <span class="dropdown button caret-down"> @icon(caret-down) </span>
    <ul class="dropdown-container">
        <li>
            <a class="pointer" onClick="setStatusAndSubmit( {{ App\Ticket::STATUS_OPEN    }} )">
                <div style="width:10px; height:10px" class="circle inline ticket-status-open mr1"></div> {{ __('ticket.commentAs') }} <b>{{ __("ticket.open") }}   </b> </a>
        </li>
        <li>
            <a class="pointer" onClick="setStatusAndSubmit( {{ App\Ticket::STATUS_PENDING }} )">
                <div style="width:10px; height:10px" class="circle inline ticket-status-pending mr1"></div> {{ __('ticket.commentAs') }} <b>{{ __("ticket.pending") }}</b> </a>
        </li>
        <li>
            <a class="pointer" onClick="setStatusAndSubmit( {{ App\Ticket::STATUS_SOLVED  }} )">
                <div style="width:10px; height:10px" class="circle inline ticket-status-solved mr1"></div> {{ __('ticket.commentAs') }} <b>{{ __("ticket.solved") }} </b> </a>
        </li>
    </ul>
    @endif {{ Form::close() }}
</div>
@endif
    @include('components.ticketComments', ["comments" => $ticket->commentsAndNotesAndEvents()->sortBy('created_at')->reverse()
])
@endsection
 
@section('scripts')
    @include('components.js.taggableInput', ["el" => "tags", "endpoint" => "tickets", "object"
=> $ticket])
<script>
    window.timestampVal = $('#total_time_stamp').val();
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
    setInterval(function(){
        let status = $("#total_time_stamp").attr("data-status");
        timestampVal++;
        var duration = moment.duration(timestampVal, 'seconds'); 
        if(status!='0'){
            $('#total_timer_container').text(formatTime(duration.hours()) + ":" + formatTime(duration.minutes())+ ":" + formatTime(duration.seconds()));
        }
    },1000)

    function formatTime(value){
        if(value < 10){
            return '0' + value;
        }else{
            return value
        }
    }

</script>
@endsection