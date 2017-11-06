@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>{{ trans_choice('idea.roadmap' , 2)}}</h3>
    </div>

    <div class="bg-broken-white b pv2 pl4 mb4">
        @foreach(config('issues.repositories') as $repoName => $repo)
            <a href="{{route('roadmap.index')}}?repository={{$repo}}">{{$repoName}}</a> |
        @endforeach
    </div>

    <div class="grid">
        @foreach($ideas as $section)
        <div class="w30">
            @foreach($section as $idea)
                <div class="panel mv2">
                    <span class="label ticket-status-{{ $idea->statusName() }}">{{ $idea->statusName()[0] }} </span>
                    <a href="{{route('ideas.show', $idea)}}">{{ $idea->title }}</a>
                    <div class="lighter-gray mt2">
                        ({{ $idea->score() }}) {{ $idea->repositoryName() }} {{ $idea->due_date }}
                    </div>
                </div>
            @endforeach
        </div>
        @endforeach
    </div>


@endsection