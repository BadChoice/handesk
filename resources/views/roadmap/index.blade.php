@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>{{ trans_choice('idea.roadmap' , 2)}}</h3>
    </div>

    <div class="bg-broken-white b pv4 pl4 mb4">
        {{ Form::open(["url" => route('roadmap.index'), 'method' => 'GET', 'id' => 'repo-selector']) }}
        {{ __('idea.repository') }} {{ Form::select('repository', array_flip(config('issues.repositories'))), request('repository') }}
        {{ Form::close() }}
    </div>

    <div class="grid">
        @foreach($ideas as $section)
        <div class="w30">
            @foreach($section as $idea)
                <div class="panel mv2">
                    <span class="label idea-status-{{ $idea->statusName() }}">{{ $idea->statusName()[0] }}</span>
                    <a href="{{route('ideas.show', $idea)}}">{{ $idea->title }}</a>
                    <div class="lighter-gray mt2">
                        ({{ $idea->score() }}) {{ $idea->repositoryName() }}
                    </div>
                    @if($idea->due_date)
                        <div class="gray mt-3 float-right">@icon(clock-o) {{ $idea->due_date }}</div>
                    @endif
                </div>
            @endforeach
        </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    <script>
    $('select').on('change', function() {
        $('#repo-selector').submit();
    });
    </script>
@endsection