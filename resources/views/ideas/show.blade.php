@extends('layouts.app')
@section('content')
    <div class="description comment">
        <div class="breadcrumb">
            <a href="{{ route('ideas.index') }}"> {{ trans_choice('idea.idea',2) }} </a>
        </div>

        <h3>#{{ $idea->id }}. {{ $idea->title }} </h3>
        @busy <span class="label idea-status-{{ $idea->statusName() }}">{{ __("idea." . $idea->statusName() ) }} </span> &nbsp;
        <span class="date">{{  $idea->created_at->diffForHumans() }} · {{  $idea->requester->name }} &lt;{{$idea->requester->email}}&gt;</span>
        <h4> {{ __('idea.score') }}: {{ $idea->score() }} </h4>

        @can('update', $idea)
            <div class="float-right mt-4 mr4 ml-3">
                <a class="button secondary mr4 fs2" href="{{route('ideas.edit', $idea)}}"> @icon(pencil) {{ __('idea.edit') }} </a>
                @include('components.idea.issue')
            </div>
        @endcan
    </div>

    <div class="comment new-comment">
        {!! nl2br( strip_tags($idea->body)) !!}
    </div>

    <div class="comment new-comment">
        <table class="maxw600 no-padding">
            <tr><td> {{ trans_choice('ticket.tag',2) }}</td><td colspan="4"> <input id="tags" name="tags" value="{{ $idea->tagsString() }}"></td></tr>
            <tr><td> {{ __('idea.repository') }} </td><td> {{ $idea->repositoryName() }} </td></tr>
            <tr><td> {{ __('idea.developmentEffort') }}</td><td><input name="development_effort" type="range" min="0" max="10" value="{{$idea->development_effort}}"></td></tr>
            <tr><td> {{ __('idea.salesImpact') }}</td><td><input name="sales_impact" type="range" min="0" max="10" value="{{$idea->sales_impact}}"></td></tr>
            <tr><td> {{ __('idea.currentImpact') }}</td><td><input name="current_impact" type="range" min="0" max="10" value="{{$idea->current_impact}}"></td></tr>
        </table>
    </div>
@endsection


@section('scripts')
    @include('components.js.taggableInput', ["el" => "tags", "endpoint" => "ideas", "object" => "{{$idea->id}}"])
@endsection