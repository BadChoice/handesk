@extends('layouts.app')
@section('content')
    <div class="description comment">
        <div class="breadcrumb">
            <a href="{{ route('ideas.index') }}"> {{ trans_choice('idea.idea',2) }} </a>
        </div>

        <h3>#{{ $idea->id }} {{ $idea->title }}</h3>
        @busy <span class="label idea-status-{{ $idea->statusName() }}">{{ __("idea." . $idea->statusName() ) }} </span> &nbsp;
        <span class="date">{{  $idea->created_at->diffForHumans() }} · {{  $idea->requester->name }} &lt;{{$idea->requester->email}}&gt;</span>
    </div>


    {{ Form::open(["url" => route('ideas.update', $idea), 'method' => 'PUT']) }}
    <div class="comment new-comment bg-broken-white">
        <table>
        <tr><td> <input class="w100" name="title" value="{{ $idea->title }}"></td></tr>
        <tr><td> <textarea name="body">{{$idea->body}}</textarea></td></tr>
        <tr><td> <input id="tags" name="tags" value="{{ $idea->tagsString() }}"></td></tr>
        </table>
    </div>
    <div class="comment new-comment grid">
        <table class="w50">
            <tr><td> {{__('idea.dueDate')}}</td><td><input type="date" name="due_date" value="{{$idea->due_date}}"></td></tr>
            <tr><td>{{ __('ticket.status') }}</td><td>
                    {{ Form::select("status", [
                        App\Idea::STATUS_NEW        => __("ticket.new"),
                        App\Idea::STATUS_ACCEPTED  => __('idea.accepted'),
                        App\Idea::STATUS_OPEN      => __("ticket.open"),
                        App\Idea::STATUS_RESOLVED  => __('ticket.solved'),
                        App\Idea::STATUS_CLOSED    => __('ticket.closed'),
                        App\Idea::STATUS_DECLINED  => __('idea.declined'),
                        //App\Idea::STATUS_MERGED    => __('ticket.merged'),
                    ], $idea->status) }}
                </td></tr>
                <tr><td> {{ __('idea.repository') }} </td><td> {{ Form::select('repository', array_flip(config('issues.repositories')), $idea->repository) }} </td></tr>
            </table>
            <table class="w50">
                <tr><td> {{ __('idea.developmentEffort') }}</td><td><input name="development_effort" type="range" min="0" max="10" value="{{$idea->development_effort}}"></td></tr>
                <tr><td> {{ __('idea.salesImpact') }}</td><td><input name="sales_impact" type="range" min="0" max="10" value="{{$idea->sales_impact}}"></td></tr>
                <tr><td> {{ __('idea.currentImpact') }}</td><td><input name="current_impact" type="range" min="0" max="10" value="{{$idea->current_impact}}"></td></tr>
            </table>
            <button class="ml4 mt2 uppercase"> {{__("idea.save") }}</button>
        {{ Form::close() }}
    </div>
@endsection


@section('scripts')
    @include('components.js.taggableInput', ["el" => "tags", "endpoint" => "ideas", "object" => $idea])
@endsection