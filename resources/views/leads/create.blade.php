@extends('layouts.app')
@section('content')
    <div class="description comment">
        <a href="{{ route('leads.index') }}"> {{ trans_choice('lead.lead',2) }} </a>
    </div>

    {{ Form::open(["url" => route("leads.store")]) }}
    <div class="comment new-comment">
        <table>
            <tr>
                <td>{{ __('lead.company') }}:</td><td>   <input name="company">   </td>
                <td>{{ __('lead.name') }}:</td><td>      <input name="name" required>  </td>
            </tr><tr>
                <td>{{ __('lead.email') }}:</td><td>     <input name="email"> </td>
                <td>{{ __('lead.phone') }}:</td><td>     <input name="phone"> </td>
                <td>{{ __('lead.username') }}:</td><td>  <input name="username">  </td>
            </tr><tr>
                <td>{{ __('lead.address') }}:</td><td>   <input name="address">   </td>
                <td>{{ __('lead.city') }}:</td><td>  <input name="city">  </td>
                <td>{{ __('lead.country') }}:</td><td>   <input name="country">   </td>
                <td>{{ __('lead.postalCode') }}:</td><td>    <input name="postal_code">    </td>
            </tr>
            <tr>
                <td>{{ __('team.team') }}:</td>
                @can("assignToTeam", new App\Ticket)
                    <td>{{ Form::select('team_id', createSelectArray( App\Team::all(),true)) }}
                @else
                    <td>{{ Form::select('team_id', createSelectArray( auth()->user()->teams,false)) }}
                @endcan
            </tr>
            <tr><td> {{ trans_choice('ticket.tag',2) }}</td><td colspan="4"> <input id="tags" name="tags" ></td></tr>
            <tr><td colspan="3"><button class="uppercase"> {{ __('ticket.new') }}</button></td></tr>
        </table>
        {{ Form::close() }}
    </div>
@endsection


@section('scripts')
    @include('components.js.taggableInput', ["el" => "tags", "endpoint" => "leads", "object" => null])
@endsection