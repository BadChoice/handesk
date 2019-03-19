@php if (! isset($type)) $type = new App\Type; 
@endphp
<tr>
    <td>{{ trans_choice('type.type',1) }}:</td>
    <td>
        {{ Form::select('type_id', createSelectArray( App\Type::all(), true), $type->id, ['class' => 'w100']) }}
    </td>
</tr>