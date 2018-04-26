@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>{{ trans_choice('macro.macro', 2) }} ( {{ $macros->count() }} )</h3>
    </div>

    <div class="m4">
        <a class="button " href="{{ route("macros.create") }}">@icon(plus) {{ __('macro.newMacro') }}</a>
    </div>


    <div id="results"></div>
    <div id="all">
        @paginator($macros)

        @paginator($macros)
    </div>
@endsection

