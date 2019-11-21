@extends('layouts.app')
@section('content')
    <div class="description">
        <h3> {{ __('user.profile') }}</h3>
    </div>

    <div class="description actions comment mb4">
        <div class="float-left ml4  shadow-outer-1 circle">@gravatar($user->email, 90)</div>
        <h3 class="ml4 float-left"> @if($user->assistant) <span class="gold">@icon(star)</span> @endif {{ $user->name }}</h3>
        <div class="clear-both mb-5"> </div>
    </div>

    <div class="clear-both"></div>

    <div class="description mt4 new-comment">
        {{ Form::open( ["url" => route('profile.update'), 'method' => 'PUT'] ) }}
        <table class="maxw600">
            <tr><td> {{ __('user.name')     }}: </td><td class="w60">{{ Form::text('name',                     $user->name,    ["class" => "w100"]) }}</td></tr>
            <tr><td> {{ __('user.email')    }}: </td><td class="w60">{{ Form::email('email',                   $user->email,   ["class" => "w100"]) }}</td></tr>
            <tr><td> {{ __('user.language') }}: </td><td>{{ Form::select('locale', App\Language::available(),   $user->locale                       ) }}</td></tr>
            <tr><td></td></tr>
            <tr><td><H2>{{ trans_choice('user.notification', 2) }}</H2></td></tr>
            <tr><td>{{ __('user.newTicketNotification')     }}  </td><td> {{ Form::checkbox('new_ticket_notification',true, $user->settings->new_ticket_notification) }}</td></tr>
            <tr><td>{{ __('user.ticketAssignedNotification')}}  </td><td> {{ Form::checkbox('ticket_assigned_notification',true, $user->settings->ticket_assigned_notification) }}</td></tr>
            <tr><td>{{ __('user.ticketUpdatedNotification') }}  </td><td> {{ Form::checkbox('ticket_updated_notification',true, $user->settings->ticket_updated_notification) }}</td></tr>
            <tr><td>{{ __('user.newLeadNotification')       }}  </td><td> {{ Form::checkbox('new_lead_notification',true, $user->settings->new_lead_notification) }}</td></tr>
            <tr><td>{{ __('user.leadAssignedNotification')  }}  </td><td> {{ Form::checkbox('lead_assigned_notification',true, $user->settings->lead_assigned_notification) }}</td></tr>
            <tr><td>{{ __('user.newIdeaNotification')       }}  </td><td> {{ Form::checkbox('new_idea_notification',true, $user->settings->new_idea_notification) }}</td></tr>
            <tr><td>{{ __('user.dailyTasksNotification')    }}: </td><td> <input type="checkbox" name="daily_tasks_notification" @if( $user->settings->daily_tasks_notification ) checked @endif></td></tr>
            <tr><td>{{ __('user.mentionNotification')       }}: </td><td> <input type="checkbox" name="mention_notification" @if( $user->settings->mention_notification ) checked @endif></td></tr>
            <tr><td>{{ __('user.ticketRated')       }}:         </td><td> <input type="checkbox" name="ticket_rated_notification" @if( $user->settings->ticket_rated_notification ) checked @endif></td></tr>
            <tr><td>{{ __('user.ticketEscalated')       }}:     </td><td> <input type="checkbox" name="escalated_ticket_notification" @if( $user->settings->escalated_ticket_notification ) checked @endif></td></tr>
            <tr><td></td></tr>
            <tr><td>{{ __('user.ticketsSignature')          }}: </td><td><textarea name="tickets_signature"> {{ $user->settings->tickets_signature }} </textarea> </td></tr>
            <tr><td><button class="ph4 uppercase">@busy {{ __('ticket.update') }}</button></td></tr>
        </table>
        {{ Form::close() }}
    </div>

    <div class="clear-both mb4"></div>

    <a class="ml5 pointer" onClick="$('#password').toggle('fast')"> @icon(key) {{ __('user.changePassword') }}</a>
    <div id="password" class="comment actions hidden mt3">
        {{ Form::open( ["url" => route('profile.password')] ) }}
        <table class="w50 ">
            <tr><td>{{ __('user.oldPassword') }}: </td><td class="w60">{{ Form::password('old', ["class" => "w100"]) }}</td></tr>
            <tr><td>{{ __('user.newPassword') }}: </td><td class="w60">{{ Form::password('password', ["class" => "w100"]) }}</td></tr>
            <tr><td>{{ __('user.confirmPassword') }}: </td><td class="w60">{{ Form::password('password_confirmation', ["class" => "w100"]) }}</td></tr>
            <tr><td><button class="ph4 uppercase">  {{ __('user.changePassword') }}</button></td></tr>
        </table>
        {{ Form::close() }}
    </div>
@endsection
