<div id="ticket-info" class="">
    @busy <span class="label ticket-status-{{ $ticket->statusName() }}">{{ __("ticket." . $ticket->statusName() ) }}</span> &nbsp;
    @busy <span class="label ticket-priority-{{ $ticket->priorityName() }}">{{ __("ticket." . $ticket->priorityName() ) }}</span> &nbsp;
    @busy <span class="label" style="background-color:{{$ticket->type->color ?? "white"}}"> {{ $ticket->type->name ?? "--" }}</span>
    <span class="date">{{  $ticket->created_at->diffForHumans() }} · {{  $ticket->requester->name }} &lt;{{$ticket->requester->email}}&gt;</span>
    <button class="ternary" onClick="$('#ticket-info').hide(); $('#ticket-edit').show()">@icon(pencil)</button>
    <div class="mt2">
        <span>{{ $ticket->subject }}</span><br>
        <p>{{ $ticket->summary }}</p>
    </div>
    {{--<a class="ml4" title="Public Link" href="{{route('requester.tickets.show',$ticket->public_token)}}"> @icon(globe) </a>--}}
</div>
<div id="ticket-edit" class="hidden" class="">
{{ Form::open(["url" => route("tickets.update", $ticket) ,"method" => "PUT"]) }}
<select name="priority">
    <option value="{{\App\Ticket::PRIORITY_LOW}}"  @if($ticket->priority == App\Ticket::PRIORITY_LOW) selected @endif         >{{ __("ticket.low") }}</option>
    <option value="{{\App\Ticket::PRIORITY_NORMAL}}"  @if($ticket->priority == App\Ticket::PRIORITY_NORMAL) selected @endif   >{{ __("ticket.normal") }}</option>
    <option value="{{\App\Ticket::PRIORITY_HIGH}}"  @if($ticket->priority == App\Ticket::PRIORITY_HIGH) selected @endif       >{{ __("ticket.high") }}</option>
    <option value="{{\App\Ticket::PRIORITY_BLOCKER}}"  @if($ticket->priority == App\Ticket::PRIORITY_BLOCKER) selected @endif >{{ __("ticket.blocker") }}</option>
</select>
<select name="type">
    @foreach(\App\TicketType::all() as $type)
        <option value="{{$type->id}}" @if($ticket->type && $type->id == $ticket->type->id) selected @endif >{{ $type->name }}</option>
    @endforeach
</select>
<input name="requester[name]" value="{{  $ticket->requester->name }}">
<input name="requester[email]" value="{{$ticket->requester->email}}">
<br>
<input name="subject" placeholder="Subject" value="{{$ticket->subject}}" style="width:475px; margin-top:4px">
<br>
<textarea name="summary" placeholder="Summary" style="width:475px; height:60px; margin-top:4px; margin-bottom:4px;">{{$ticket->summary}}</textarea>
<br>
<button class="mt-2"> {{ __("ticket.update")}} </button>
{{ Form::close() }}
</div>