@extends('layouts.app')
@section('content')
    <div class="description comment">
        <a href="{{ route('leads.index') }}">Leads</a>
        <h3> {{ $lead->company }} · {{ $lead->email }} </h3>
        @busy <span class="label ticket-status-{{ $lead->statusName() }}"> {{ __("ticket.".$lead->statusName() ) }} </span> &nbsp;
        <span class="date">{{  $lead->created_at->diffForHumans() }} · {{  nameOrDash($lead->team) }}</span>
        <br>
    </div>

    <div class="description comment actions">
        <div class="w-50">
            <table>
                <tr>
                    <td class="small">{{ trans_choice('ticket.tag',2) }}:</td>
                    <td colspan="2"> <input id="tags" name="tags" value="{{$lead->tagsString()}}"></td>
                </tr>
                @can("assignToTeam", $lead)
                        {{ Form::open(["url" => route('leads.assign', $lead)]) }}
                    <tr>
                        <td class="small">{{ __('team.team') }}:</td>
                        <td>{{ Form::select('team_id', createSelectArray( App\Team::all(),true), $lead->team_id ) }}</td>
                        <td class="text-right"> <button class="uppercase ph4"> {{ __('ticket.assign') }}</button></td>
                    </tr>
                        {{ Form::close() }}
                @endcan
            </table>
        </div>
    </div>

    <div class="comment new-comment">
        {{ Form::open(["url" => route("comments.store",$lead)]) }}
        <textarea name="body"></textarea>
        <br>
        {{ Form::select("new_status", App\Lead::availableStatus(), $lead->status) }}
        <button class="uppercase ph3 ml1"> @icon(comment) {{ __('ticket.comment') }}</button>
        {{ Form::close() }}
    </div>
    @include('components.leadStatus')
@endsection

@section('scripts')
    <script>
        $('#tags').tagsInput({
            'height': '20px',
            'width': '100%',
            'onAddTag': onAddTag,
            'onRemoveTag': onRemoveTag,
            'placeholderColor': '#bbb',
            'defaultText': "Add...",
        });

        function onAddTag(tag){
            $.post({
                url: "{{route("leads.tags.store",$lead)}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "tag": tag
                }
            });
        }

        function onRemoveTag(tag){
            $.ajax({
                url: "{{ route("leads.tags.store",$lead)}}" + "/" + tag,
                method : "DELETE",
                data:{
                    "_token" : "{{ csrf_token() }}",
                }
            });
        }
    </script>
@endsection