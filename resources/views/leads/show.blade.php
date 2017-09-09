@extends('layouts.app')
@section('content')
    <div class="description comment">
        <div class="breadcrumb">
            <a href="{{ route('leads.index') }}">{{ trans_choice('lead.lead', 2) }}</a>
        </div>
        <h3> {{ $lead->company }} · {{ $lead->name }} · {{ $lead->email }} </h3>
        @busy <span class="label lead-status-{{ $lead->statusName() }}"> {{ __("lead." . $lead->statusName() ) }} </span> &nbsp;
        <span class="date">{{  $lead->created_at->diffForHumans() }} · {{  nameOrDash($lead->team) }}</span>
        <a class="float-right button secondary mr4 mt-4 mb-5" href="{{ route('leads.tasks.index', $lead) }}"> @icon(tasks) {{ trans_choice('lead.task', 2) }} <span class="label lead-status-failed">{{ $lead->uncompletedTasks->count() }}</span></a>
    </div>

    <div class="description comment">
        {{ Form::open(["url" => route('leads.update',$lead), 'method' => "PUT"]) }}
            @include('components.lead.fields', ["lead" => $lead])
            <button class="uppercase"> {{ __('ticket.update') }}</button>
        {{ Form::close() }}
    </div>
    @include('components.assignActions', ["endpoint" => "leads", "object" => $lead])

    <div class="comment new-comment">
        {{ Form::open(["url" => route("leads.status.store",$lead), "files" => true, "id" => "comment-form"]) }}
        <textarea name="body"></textarea>
        <br>
        @include('components.uploadAttachment', ["attachable" => $lead, "type" => "leads"])
        {{ Form::hidden("new_status", $lead->status, ["id" => "new_status"]) }}

        <button class="mt1 uppercase ph3"> @icon(comment) {{ __('ticket.commentAs') }} {{ __("lead." . $lead->statusName()) }}</button>
        <span class="dropdown button caret-down"> @icon(caret-down) </span>
        <ul class="dropdown-container">
            @foreach(App\Lead::availableStatus() as $value => $status)
                <li><a class="pointer" onClick="setStatusAndSubmit( {{ $value    }} )"><div style="width:10px; height:10px" class="circle inline lead-status-{{$status}} mr1"></div> {{ __('ticket.commentAs') }} <b>{{ __("lead.$status") }}   </b> </a></li>
            @endforeach
        </ul>
        {{ Form::close() }}
    </div>
    @include('components.leadStatus')
@endsection

@section('scripts')
    @include('components.js.taggableInput', ["el" => "tags", "endpoint" => "leads", "object" => $lead])
    <script>
        function setStatusAndSubmit(new_status){
            $("#new_status").val(new_status);
            $("#comment-form").submit();
        }
    </script>
@endsection