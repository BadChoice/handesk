@extends('layouts.app')
@section('content')
    <div class="description comment">
        <div class="breadcrumb">
            <a href="{{ url()->previous() }}">{{ trans_choice('macro.macro', 2) }}</a>
        </div>
    </div>

    {{ Form::open(["url" => route("macros.store")]) }}
    <div class="comment new-comment">
        <table class="maxw600 no-padding">
            <tr><td>{{ __('macro.availableTo') }}: </td><td>
                    {{ Form::select("available_to", array_merge([
                        App\Macro::AVAILABLE_TO_ME => __("macro.me"),
                        App\Macro::AVAILABLE_TO_TEAM => __("macro.myTeams"),
                    ],
                    auth()->user()->admin ? [App\Macro::AVAILABLE_TO_ALL => __("macro.all")] : []
                    )) }}
                </td>
            </tr>

            <tr><td class="w20">{{__('macro.title')}}: </td>     <td><input name="title" class="w100" required/></td></tr>
            <tr><td>{{ __('ticket.comment')         }}: </td><td><textarea  name="body" required></textarea></td></tr>
            <tr><td></td></tr>
            <tr><td>{{ trans_choice('macro.setTags', 2)}}: </td><td><input     name="tags" id="tags"/></td></tr>

            @can(auth()->user()->admin)
                <td>{{ __('macro.assignTo') }}:</td>
                <td>{{ Form::select('user_id', App\Team::membersByTeam() ) }}</td>
            @else
                <td>{{ __('macro.assignTo') }}:</td>
                <td>{{ Form::select('user_id', createSelectArray( auth()->user()->teamsMembers(), true) ) }}</td>
            @endcan

            <tr><td>{{ __('macro.setStatus') }}: </td><td>
                {{ Form::select("status", [
                    ""                          => "--",
                    App\Ticket::STATUS_NEW      => __("ticket.new"),
                    App\Ticket::STATUS_OPEN     => __("ticket.open"),
                    App\Ticket::STATUS_PENDING  => __("ticket.pending"),
                    App\Ticket::STATUS_SOLVED   => __("ticket.solved"),
                ]) }}
                 </td>
            </tr>
        </table>
        <button class="uppercase ph3 ml1"> @icon(magic) {{ __('ticket.new') }}</button>
        {{ Form::close() }}
    </div>
@endsection


@section('scripts')
    @include('components.js.taggableInput', ["el" => "tags", "endpoint" => "tickets", "object" => null])
@endsection