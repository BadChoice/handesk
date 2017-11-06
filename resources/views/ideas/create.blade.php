@extends('layouts.app')
@section('content')
    <div class="description comment">
        <div class="breadcrumb">
            <a href="{{ route('ideas.index') }}"> {{ trans_choice('idea.idea',2) }} </a>
        </div>
    </div>

    {{ Form::open(["url" => route("ideas.store")]) }}
    <div class="comment description actions">
        <table class="maxw600 no-padding">
            <tr><td class="w20"><b> {{ __('ticket.requester') }}:</b></td></tr>
            <tr><td>{{ __('user.name')  }}: </td><td class="w100"><input type="name"  name="requester[name]"  class="w100" required></td></tr>
            <tr><td>{{ __('user.email') }}: </td><td class="w100"><input type="email" name="requester[email]" class="w100" required></td></tr>
        </table>
    </div>
    <div class="comment new-comment">
        <table class="maxw600 no-padding">
            <tr><td class="w20">Subject: </td>     <td><input name="title" class="w100" required/></td></tr>
            <tr><td> {{ trans_choice('ticket.tag',2) }}</td><td colspan="4"> <input id="tags" name="tags" value="{{request('tags')}}"></td></tr>
            <tr><td> {{__('ticket.comment') }}</td><td colspan="7"><textarea name="body" required> {{ request('body') }}</textarea></td></tr>
            <tr><td> {{ __('idea.developmentEffort') }}</td><td><input name="development_effort" type="range" min="0" max="10"></td></tr>
            <tr><td> {{ __('idea.salesImpact') }}</td><td><input name="sales_impact" type="range" min="0" max="10"></td></tr>
            <tr><td> {{ __('idea.currentImpact') }}</td><td><input name="current_impact" type="range" min="0" max="10"></td></tr>

            <tr><td>{{ __('idea.repository') }}: </td><td>
                    {{ Form::select("repository", array_merge(["" => "--"], array_flip(config('issues.repositories')))) }}
            </td>
            <tr><td><button class="uppercase ph3 ml1"> @icon(comment) {{ __('ticket.new') }}</button> </td></tr>
        </table>
        {{ Form::close() }}
    </div>
@endsection


@section('scripts')
    @include('components.js.taggableInput', ["el" => "tags", "endpoint" => "ideas", "object" => null])
@endsection