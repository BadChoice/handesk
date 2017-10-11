<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Handesk') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div id="app">

{{--        @include('layouts.header')--}}
        @include('layouts.tinyHeader')
        @include('layouts.sidebar')
        <div class="content container-fluid">
            @include('components.errors')
            @yield('content')
        </div>
        {{--@include('layouts.footer')--}}
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        //TODO: Move custom scripts to a file so it can be minified with laravel mix
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
        }
        function toggleSidebar(){
            var position = 0;
            if( $('#sidebar').position().left == 0) {
                position = -350;
            }
            $('#sidebar').animate({"left":position + "px"}, 200);
        }

        var csrf_token = "{{ csrf_token() }}";
        $(".delete-resource, .delete-resource-simple").on('click',function(e){
            if (!confirm("Are you sure?")){ return false; }
            else{
                e.preventDefault();
                var url = $(this).attr('href');
                $('<form action="' + url + '" method="POST"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="' + csrf_token + '"></form>').appendTo('body').submit();
            }
        });

    </script>
    @yield('scripts')

</body>
</html>
