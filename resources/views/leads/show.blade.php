@extends('layouts.app')
@section('content')
    <div class="description comment">
        <a href="{{ route('leads.index') }}">Leads</a>
        <h3> {{ $lead->company }} · {{ $lead->name }} · {{ $lead->email }} </h3>
        @busy <span class="label lead-status-{{ $lead->statusName() }}"> {{ __("lead.".$lead->statusName() ) }} </span> &nbsp;
        <span class="date">{{  $lead->created_at->diffForHumans() }} · {{  nameOrDash($lead->team) }}</span>
        <br>
    </div>

    <div class="description comment">
        {{ Form::open(["url" => route('leads.update',$lead), 'method' => "PUT"]) }}
        <table>
            <tr>
                <td>{{ __('lead.company') }}:</td><td>   <input name="company" value="{{ $lead->company }}">   </td>
                <td>{{ __('lead.name') }}:</td><td>  <input name="name" value="{{ $lead->name }}">  </td>
            </tr><tr>
                <td>{{ __('lead.email') }}:</td><td>     <input name="email" value="{{ $lead->email }}"> </td>
                <td>{{ __('lead.phone') }}:</td><td>     <input name="phone" value="{{ $lead->phone }}"> </td>
                <td>{{ __('lead.username') }}:</td><td>  <input name="username" value="{{ $lead->username }}">  </td>
            </tr><tr>
                <td>{{ __('lead.address') }}:</td><td>   <input name="address" value="{{ $lead->address }}">   </td>
                <td>{{ __('lead.city') }}:</td><td>  <input name="city" value="{{ $lead->city }}">  </td>
                <td>{{ __('lead.country') }}:</td><td>   <input name="country" value="{{ $lead->country }}">   </td>
                <td>{{ __('lead.postalCode') }}:</td><td>    <input name="postal_code" value="{{ $lead->postal_code }}">    </td>
            </tr>
            <tr><td colspan="3"><button class="uppercase"> {{ __('ticket.update') }}</button></td></tr>
        </table>
        {{ Form::close() }}
    </div>

    @include('components.assignActions', ["endpoint" => "leads", "object" => $lead])

    <div class="comment new-comment">
        {{ Form::open(["url" => route("leads.status.store",$lead)]) }}
        <textarea name="body"></textarea>
        <br>
        {{ Form::select("new_status", App\Lead::availableStatus(), $lead->status) }}
        <button class="uppercase ph3 ml1"> @icon(comment) {{ __('ticket.comment') }}</button>
        {{ Form::close() }}
    </div>
    @include('components.leadStatus')
@endsection

@section('scripts')
    @include('components.js.taggableInput', ["el" => "tags", "endpoint" => "leads", "object" => $lead])
@endsection