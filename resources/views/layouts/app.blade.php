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
        <div id="popup" class="popup">
            <div id="popupContent"></div>
        </div>
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
    @yield('scripts')
    @stack('edit-scripts')

</body>
</html>
