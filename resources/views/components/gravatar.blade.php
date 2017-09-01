@gravatar( $user->email )
@if($user instanceof App\User && $user->assistant )
    <div class="inline ml-3 gold">@icon(star)</div>
@endif