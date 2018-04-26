@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>{{ trans_choice('lead.lead',2) }} ( {{ $leads->count() }} )</h3>
    </div>

    <div class="m4">
        <a class="button " href="{{ route("leads.create") }}">@icon(plus) {{ __('lead.newLead') }}</a>
    </div>
    <div class="float-right mt-5 mr4">
        <input id="searcher" placeholder="{{__('lead.search')}}" class="ml2 shadow-outer-3" style="border-color:#eee">
        <div class="inline ml-4">@icon(search)</div>
    </div>

    <div id="results"></div>
    <div id="all">
        @paginator($leads)
        @include('leads.indexTable')
        @paginator($leads)
    </div>
@endsection

@section('scripts')
    <script>
        $("#searcher").searcher('leads/search/');
    </script>
@endsection