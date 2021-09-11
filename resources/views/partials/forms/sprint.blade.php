<form action="{{route($route, ['slug'=>@$sprint->slug])}}" method="post" class="form-horizontal">
    {{ csrf_field() }}
    <div class="form-group">
        <label class="col-sm-12">{{trans('gitscrum.product-backlog')}}</label>
        <div class="col-sm-12">
            <select name="product_backlog_id" class="form-control m-b">
                @foreach (Auth::user()->productBacklogs() as $productBacklog)
                <option value="{{$productBacklog->id}}"
                    @if ( @$productBacklog_id == $productBacklog->id ) selected="selected" @endif >
                        {{$productBacklog->title}} ({{$productBacklog->organization->title}})</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group">
        <label class="col-sm-12">{{trans('gitscrum.timebox')}}</label>
        <div class="col-sm-12">
            <input class="form-control" type="text" name="daterange"
                value="{{ @$sprint->date_start }}@if(@$sprint->date_start) - @endif{{ @$sprint->date_finish }}" required />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-12">{{trans('gitscrum.name')}}</label>
        <div class="col-sm-12">
            <input name="title" type="text" class="form-control" value="{{ @$sprint->title }}"
                pattern=".{2,255}" title="{{trans('gitscrum.title-must-be-between-2-and-255-characters')}}"
                autocomplete="off" maxlength="255" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-12">{{trans('gitscrum.description')}} ({{trans('gitscrum.optional')}})</label>
        <div class="col-sm-12">
            <textarea name="description" type="text" class="form-control">{{ @$sprint->description }}</textarea>
            <span class="help-block m-b-none"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3">{{trans('gitscrum.version')}} ({{trans('gitscrum.optional')}})</label>
        <div class="col-sm-2">
            <input name="version" type="text" placeholder="1.0.1" class="form-control m-b-none">
        </div>
        <label class="col-sm-3">{{trans('gitscrum.public')}} ({{trans('gitscrum.optional')}})</label>
        <div class="col-sm-4">
            <select name="is_private" class="form-control m-b">
                <option value="0">{{trans('gitscrum.yes-publish-for-team')}}</option>
                <option value="1">{{trans('gitscrum.no-display-only-for-me')}}</option>
            </select>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    @include('partials.includes.form-btn-submit', ['action' => @$action])
</form>

<script type="text/javascript">
$(function() {
    $('input[name="daterange"]').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        }
    });
});
</script>
