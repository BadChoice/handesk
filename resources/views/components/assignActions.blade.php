<div class="description actions comment">
    {{ Form::open(["url" => route("{$endpoint}.assign", $object)]) }}
    <table class="w50 no-padding">
        <tr>
            <td class="small"> {{ trans_choice('ticket.tag',2) }}:</td>
            <td colspan="2"><input id="tags" name="tags" value="{{$object->tagsString()}}"></td>
        </tr>
        @can("assignToTeam", $object)
            @include('components.assignTeamField', ["team" => $object->team])
        @endcan
        <tr>
            @can("assignToTeam", $object)
                <td>{{ __('ticket.assigned') }}:</td>
                <td>{{ Form::select('user_id', App\Team::membersByTeam(), $object->user_id, ['class' => 'w100']) }}</td>
            @else
                @if ($object->team)
                    <td>{{ __('ticket.assigned') }}:</td>
                    <td>{{ Form::select('user_id', createSelectArray( $object->team->members, true), $object->user_id, ['class' => 'w100']) }}</td>
                @endif
            @endcan
        </tr>
        <tr>
            <td class="text-right" colspan="2">
                <button class="uppercase ph4"> {{ __('ticket.assign') }}</button>
            </td>
        </tr>
    </table>
    {{ Form::close() }}
</div>
