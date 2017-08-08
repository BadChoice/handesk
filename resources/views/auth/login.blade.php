<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="center text-center mt5 w-20">
            <img src="{{url("images/handesk_full.png")}}">
            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                <div class="m3">
                    <input id="email" type="email" class="w-80" name="email" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="m3">
                    <input id="password" type="password" class="w-80" name="password" required>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="mh3 mb2">
                    <button type="submit" class="uppercase ph5 w-80">Login</button>
                </div>
                <div class="mb3">
                    <input type="checkbox" class="" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    Remember Me
                </div>

                <div>
                    <a class="btn btn-link" href="{{ route('password.request') }}"> Forgot Your Password? </a>
                </div>
            </form>
    </div>
</body>
</html>
