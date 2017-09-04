@extends('layouts.app')
@section('content')
    <div class="description comment">
        <a href="{{ route('leads.index') }}"> {{ trans_choice('lead.lead',2) }} </a>
    </div>

    {{ Form::open(["url" => route("leads.store")]) }}
    <div class="comment new-comment">
        <table>
            @include('components.lead.fields', ["lead" => new App\Lead( request()->all() )])
            @include('components.assignTeamField')
            <tr><td> {{ trans_choice('ticket.tag',2) }}</td><td colspan="4"> <input id="tags" name="tags" value="{{request('tags')}}"></td></tr>
            <tr><td colspan="3"><button class="uppercase"> {{ __('ticket.new') }}</button></td></tr>
        </table>
        {{ Form::close() }}
    </div>
@endsection


@section('scripts')
    @include('components.js.taggableInput', ["el" => "tags", "endpoint" => "leads", "object" => null])
@endsection