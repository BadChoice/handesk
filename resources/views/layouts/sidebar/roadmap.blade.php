@if(auth()->user()->admin)
    <br>
    <h4> @icon(road) {{ __('idea.roadmap') }}</h4>
    @include('components.sidebarItem', ["url" => route('ideas.index').'?pending=true',      "title" => trans_choice('idea.pendingIdea',        2) ])
    @include('components.sidebarItem', ["url" => route('ideas.index').'?ongoing=true',      "title" => trans_choice('idea.idea',        2) ])
    @include('components.sidebarItem', ["url" => route('roadmap.index'),      "title" => trans_choice('idea.roadmap', 1) ])
    <ul>
@endif