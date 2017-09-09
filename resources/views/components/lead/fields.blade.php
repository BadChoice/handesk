<div class="grid">
    <div class="col-min33">
        <table class="no-padding">
            <tr><td>{{ __('lead.name') }}:</td><td>      <input name="name" value="{{ $lead->name }}" required>  </td></tr>
            <tr><td>{{ __('lead.company') }}:</td><td>   <input name="company" value="{{ $lead->company }}">   </td></tr>
            <tr><td>{{ __('lead.username') }}:</td><td>  <input name="username" value="{{ $lead->username }}">  </td></tr>
        </table>
    </div>
    <div class="col-min33">
        <table class="no-padding">
            <tr><td>{{ __('lead.email') }}:</td><td>     <input name="email" value="{{ $lead->email }}"> </td></tr>
            <tr><td>{{ __('lead.phone') }}:</td><td>     <input name="phone" value="{{ $lead->phone }}"> </td></tr>
        </table>
    </div>
    <div class="col-min33">
        <table class="no-padding">
            <tr><td>{{ __('lead.address') }}:</td><td>   <input name="address" value="{{ $lead->address }}">   </td></tr>
            <tr><td>{{ __('lead.city') }}:</td><td>  <input name="city" value="{{ $lead->city }}">  </td></tr>
            <tr><td>{{ __('lead.country') }}:</td><td>   <input name="country" value="{{ $lead->country }}">   </td></tr>
            <tr><td>{{ __('lead.postalCode') }}:</td><td>    <input name="postal_code" value="{{ $lead->postal_code }}">    </td></tr>
        </table>
    </div>
</div>