@extends('layouts.app') 
@section('content')
<div class="description">
    <a href="{{ url()->previous() }}">Types</a>
</div>
<div class="comment description actions mb4">
    <h3>New Type</h3>
</div>
{{ Form::open(["url" => route('types.store')]) }}
<table class="w50">
    <tr>
        <td>{{ __("type.name") }}: </td>
        <td><input class="w100" name="name" required> </td>
    </tr>
    <tr>
        <td>{{ __("type.isTrackable") }}: </td>
        <td class="w75">
            <input class="actionCheckbox" type="checkbox" name="is_trackable" value="1">
        </td>
    </tr>
    <tr>
        <td colspan="2"> <button class="ph4 uppercase"> @busy {{ __('type.new') }}</button> </td>
    </tr>
</table>
{{ Form::close() }}
@endsection
 
@section('scripts')
<script>
    $.switcher('input[type=checkbox]');

</script>
@endsection