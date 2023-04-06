@extends('layouts.app')
@section('content')
    <div class="description comment">
        <div class="breadcrumb">
            <a href="{{ url()->previous() }}">{{ trans_choice('ticket.ticket', 2) }}</a>
        </div>
    </div>

    {{ Form::open(["url" => route("tickets.store")]) }}
    <div class="comment description actions">
        <table class="maxw600 no-padding">
            <tr><td class="w20"><b> {{ __('ticket.requester') }}:</b></td></tr>
            <tr><td>{{ __('user.name')  }}: </td><td class="w100"><input type="name"  name="requester[name]"  class="w100" required></td></tr>
            <!-- <tr><td>{{ __('user.email') }}: </td><td class="w100"><input type="email" name="requester[email]" class="w100" required></td></tr> -->
        </table>
    </div>

    <div class="comment new-comment">
        <table class="maxw600 no-padding">
            <tr><td class="w20">{{ __('ticket.subject') }}: </td>     <td><input name="title" class="w100" required/></td></tr>
            <tr><td class="w20">{{ __('ticket.target') }}: </td>     <td><input name="target" class="w100" required/></td></tr>
            {{-- <tr><td class="w20">{{ __('ticket.position') }}: </td>     <td><input name="position" class="w100" required/></td></tr> --}}
            <tr><td class="w20">{{ __('ticket.side') }}: </td>     <td><input name="side" class="w100" required/></td></tr>
            <tr><td class="w20">{{ __('ticket.mobNumber') }}: </td>     <td><input name="mob_number" class="w100" required/></td></tr>
            <tr><td class="w20">{{ __('ticket.affiliation') }}: </td>     <td><input name="affiliation" class="w100" required/></td></tr>
            <tr>
                <td class="w20">{{ __('ticket.location') }}: </td>
                <td><textarea name="location" required></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-bottom: 10px;">@include('tickets.location-create')</td>
            </tr>
            <!-- <tr><td>{{ trans_choice('ticket.tag', 2)}}: </td><td><input     name="tags" id="tags"/></td></tr> -->
            <tr><td>{{ __('ticket.description') }}: </td><td><textarea  name="body" required></textarea></td></tr>
            <!-- @include('components.assignTeamField') -->
            <tr><td>{{ __('ticket.status') }}: </td><td>
                {{ Form::select("status", [
                    App\Ticket::STATUS_NEW      => __("ticket.new"),
                    App\Ticket::STATUS_OPEN     => __("ticket.open"),
                    App\Ticket::STATUS_SOLVED   => __("ticket.solved"),
                ]) }}
                <button class="uppercase ph3 ml1"> @icon(comment) {{ __('ticket.createNew') }}</button> </td>
            </tr>
        </table>

        
        {!! Form::text('latitude', null, ['class' => 'form-control untouch text-right hidden', 'autocomplete' => 'off', 'placeholder' => 'Masukkan Latitude', 'id' => 'lat']) !!}
    
        {!! Form::text('longitude', null, ['class' => 'form-control untouch text-left hidden', 'autocomplete' => 'off', 'placeholder' => 'Masukkan Longitude', 'id' => 'lng']) !!}

        {{ Form::close() }}
    </div>

{{-- Modal for maps coordinate --}}
@endsection


@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#location").click(function(){
              $("#mapModal").modal('show');
            });
          });
    </script>
@endsection