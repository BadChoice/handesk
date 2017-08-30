<a class="button secondary dropdown">
    @icon(calendar)
    {{ Carbon\Carbon::parse( $repository->startDate)->format("jS F Y")  }} -
    {{ Carbon\Carbon::parse( $repository->endDate)->format("jS F Y")  }}
</a>
<div class="dropdown-container">
    <div class="grid">
        <div class="p3">
            <ul class="mt-2">
                <li class="pb1"><a class="pointer" onclick="filterSetToday()">Today</a></li>
                <li class="pb1"><a class="pointer" onclick="filterSetYesterday()"> Yesterday</a></li>
                <li class="pb1"><a class="pointer" onclick="filterSetThisWeek()"> This week</a></li>
                <li class="pb1"><a class="pointer" onclick="filterSetThisMonth()"> This Month</a></li>
                <li class="pb1"><a class="pointer" onclick="filterSetLastDays(30)"> Last 30 days</a></li>
                <li class="pb1"><a class="pointer" onclick="filterSetLastDays(60)"> Last 60 days</a></li>
                <li class="pb3"><a class="pointer" onclick="filterSetLastDays(90)"> Last 90 days</a></li>
                <li class=""><a class="button secondary pointer" onclick="$('#custom-date-range').show('fast')"> Custom range</a></li>
            </ul>
        </div>
        <div id="custom-date-range" class="pl3 pt1 hidden bl">
            @icon(calendar)
            {{ Form::input('date', 'startDate', $repository->startDate, ["id" => "start_date"]) }}
            {{ Form::input('date', 'endDate',   $repository->endDate,   ["id" => "end_date"]) }}
            <div class="mt3 text-right"><button id="filter_date_button"> @icon(filter) {{ __('report.filter') }}</button></div>
        </div>
    </div>
</div>

{{ Html::script('js/moment.js') }}
<script>
    function filterSetToday(){
        var today = moment().format('YYYY-MM-DD');
        $('#start_date').val( today );
        $('#end_date')  .val( today );
        $('#filter_date_button').click();
    }

    function filterSetYesterday() {
        var yesterday   = moment().subtract(1, 'days').format('YYYY-MM-DD');
        $('#start_date').val( yesterday );
        $('#end_date')  .val( yesterday );
        $('#filter_date_button').click();
    }

    function filterSetThisWeek() {
        var start   = moment().startOf('week').add(1,'days').format('YYYY-MM-DD');
        var end     = moment().format('YYYY-MM-DD');
        $('#start_date').val( start );
        $('#end_date')  .val( end );
        $('#filter_date_button').click();
    }

    function filterSetThisMonth() {
        var start   = moment().startOf('month').format('YYYY-MM-DD');
        var end = moment().format('YYYY-MM-DD');
        $('#start_date').val( start );
        $('#end_date')  .val( end );
        $('#filter_date_button').click();
    }

    function filterSetLastDays( days ) {
        var start   = moment().subtract(days, 'days').format('YYYY-MM-DD');
        var end     = moment().format('YYYY-MM-DD');
        $('#start_date').val( start );
        $('#end_date')  .val( end );
        $('#filter_date_button').click();
    }
</script>