@extends('layouts.app')
@section('content')
    <div class="description comment">
        <a href="{{ url()->previous() }}">Tickets</a>
    </div>

    {{ Form::open(["url" => route("tickets.store")]) }}
    <div class="comment description actions">
        <table class="w50">
            <tr><td class="w20"><b> {{ __('ticket.requester') }}:</b></td></tr>
            <tr><td>Name: </td>     <td class="w100"><input type="name" name="requester[name]" class="w100" required></td></tr>
            <tr><td>Email:  </td>   <td class="w100"><input type="email" name="requester[email]" class="w100" required></td></tr>
        </table>
    </div>

    <div class="comment new-comment">
        <table class="w50">
            <tr><td class="w20">Subject: </td>     <td><input name="title" class="w100" required/></td></tr>
            <tr><td>Tags:       </td>               <td><input name="tags" id="tags"/></td></tr>
            <tr><td>Comment:    </td>               <td><textarea name="body" required></textarea></td></tr>
            @include('components.assignTeamField')
            <tr><td>Status:     </td><td>
                {{ Form::select("status", [
                    App\Ticket::STATUS_NEW     => __("ticket.new"),
                    App\Ticket::STATUS_OPEN     => __("ticket.open"),
                    App\Ticket::STATUS_PENDING  => __("ticket.pending"),
                ]) }}
                <button class="uppercase ph3 ml1"> @icon(comment) {{ __('ticket.new') }}</button> </td>
            </tr>
        </table>
        {{ Form::close() }}
    </div>
@endsection


@section('scripts')
    @include('components.js.taggableInput', ["el" => "tags", "endpoint" => "tickets", "object" => null])
@endsection