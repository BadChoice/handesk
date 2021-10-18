@extends('layouts.requester')
@section('content')


<style>
.ticket-header{
    box-shadow: rgba(0, 0, 0, 0.075) 0px 0.125rem 0.25rem;
}   

.ticket-header-logo{
    margin: 20px 0px 3px 0;;
}
</style>

<div class="ticket-header">
    <div class="thrust-index-header description">
        <img src="{{ url("/images/service-certainty-logo.jpg") }}" class="ticket-header-logo" width="220px" /> 
    </div>
</div>
<div class="container-fluid">

    <div class="description mt4">
        <span class="fs4 bold">
        Add a new ticket
</span>

    </div>

    <div class="description mb3">
        <span>Please add your details and describle the issue you are having, then click "New"</span>
    </div>

    {{ Form::open(["url" => route("requester.newticket"), "class" => "card"]) }}
    <div class="comment description actions">
        <table class="maxw600 no-padding">
            <tr><td class="w20"><b> {{ __('ticket.requester') }}:</b></td></tr>
            <tr><td>{{ __('user.name')  }}: </td><td class="w100"><input type="name"  name="requester[name]"  class="w100" required></td></tr>
            <tr><td>{{ __('user.email') }}: </td><td class="w100"><input type="email" name="requester[email]" class="w100" required></td></tr>
        </table>
    </div>

    <div class="description new-comment">
        <table class="maxw600 no-padding">
            <tr><td class="w20">{{ __('ticket.subject') }}: </td>     
            <td><input name="title" class="w100" required/></td></tr>
            <tr><td>{{ trans_choice('ticket.tag', 2)}}: </td><td><input name="tags" id="tags"/><p class="mv1">Separate tags with commas</p></td></tr>
            <tr><td>Issue: </td><td><textarea name="body" required></textarea></td></tr>
            
            <tr><td>{{ __('ticket.status') }}: </td><td>
                {{ Form::select("status", [
                    App\Ticket::STATUS_NEW      => __("ticket.new"),
                    App\Ticket::STATUS_OPEN     => __("ticket.open"),
                    App\Ticket::STATUS_PENDING  => __("ticket.pending"),
                ]) }}
                <button class="uppercase ph3 ml1"> @icon(comment) {{ __('ticket.new') }}</button> </td>
            </tr>
        </table>
        {{ Form::close() }}
    </div>

</div>
@endsection


@section('scripts')
    @include('components.js.taggableInput', ["el" => "tags", "endpoint" => "tickets", "object" => null])
@endsection
