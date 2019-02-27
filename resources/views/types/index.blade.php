@extends('layouts.app') 
@section('content')
<div class="description">
    <h3>Types ( {{ $types->count() }} )</h3>
</div>

@if(auth()->user()->admin)
<div class="m4">
    <a class="button " href="">@icon(plus) {{ __('type.new') }}</a>
</div>
@endif @paginator($types)
<table class="striped">
    <thead>
        <tr>
            <th class="small"></th>
            <th> {{ trans_choice('type.name',1) }} </th>
            <th colspan="2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($types as $type)
        <tr>
            <td></td>
            <td>{{ $type->name }}</td>
            <td><a href=""> @icon(pencil)</a></td>
            <td><a href="" class="delete-resource"> @icon(trash)</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@paginator($types)
@endsection