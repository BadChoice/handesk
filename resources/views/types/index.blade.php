@extends('layouts.app') 
@section('content')
<div class="description">
    <h3>Types ( {{ $types->count() }} )</h3>
</div>

@if(auth()->user()->admin)
<div class="m4">
    <a class="button " href="{{ route('types.create') }}">@icon(plus) {{ __('type.new') }}</a>
</div>
@endif @paginator($types)
<table class="striped">
    <thead>
        <tr>
            <th class="small"></th>
            <th> {{ trans_choice('type.name',1) }} </th>
            <th> {{ trans_choice('type.isTrackable',1) }} </th>
            <th colspan="2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($types as $type)
        <tr>
            <td></td>
            <td>{{ $type->name }}</td>
            <td><input class="actionCheckbox" {{ $type->is_trackable? 'checked': '' }} disabled type="checkbox" name="is_trackable"
                value="1">
            </td>
            <td><a class="action-icon" href="{{ route('types.update',$type) }}"> @icon(pencil)</a></td>
            <td>
                <span class="action-icon" onclick="deleteType({{ $type->id }})">@icon(trash)</span>
                <form action="{{ route('types.destroy', [$type->id])}}" method="POST" id="delete-form-{{ $type->id }}">
                    {{method_field('DELETE')}}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@paginator($types)
@endsection
 
@section('scripts')
<script>
    function deleteType(id){
        let formID = '#'+'delete-form-'+id;
        $.confirm({
            title: 'Confirm!',
            closeIcon: true,
            boxWidth: '500px',
            icon: 'fa fa-warning',
            content: 'Are you sure remove this type?',
            useBootstrap: false,
            buttons: {
                confirm: function () {
                    $(formID).submit();
                },
                cancel: function () {
                   
                }
               
            }
        });
    }
    $.switcher('input[type=checkbox]');

</script>
<style>
    .action-icon {
        cursor: pointer;
    }
</style>
@endsection