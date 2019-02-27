@extends('layouts.app') 
@section('content')
<div class="description">
    <div class="breadcrumb">
        <a href="{{ url()->previous() }}">Back</a>
    </div>
</div>

<div class="clear-both"></div>

<div class="description mt4">
    {{ Form::open(["url" => route('types.update',$type), "method" => "PUT"]) }}
    <table class="maxw600">
        <tr>
            <td>{{ __("type.name") }}: </td>
            <td class="w60"><input class="w100" name="name" value="{{$type->name}}"> </td>
        </tr>
        <tr>
            <td><button class="ph4 uppercase">@busy {{ __('type.update') }}</button></td>
        </tr>
    </table>
    {{ Form::close() }}
</div>
@endsection