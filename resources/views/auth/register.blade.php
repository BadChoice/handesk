@extends('auth.layout')

@section('content')

    <div class="center text-center mt5 w40">
        <img src="{{url("images/handesk_full.png")}}" class="w40">
        <p class="w60 center"> {{ __('team.invitedDesc') }}</p>
        <h3>Register</h3>
            <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                <table>
                    <tr>
                        <td class="w40">Name:</td>
                        <td class="w60">
                            <input id="name" type="text" class="w100" name="name" value="{{ old('name') }}" required autofocus>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td>E-Mail Address:</td>
                        <td>
                                <input id="email" type="email" class="w100" name="email" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td>
                            <input id="password" type="password" class="w100" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td>Confirm Password</td>
                        <td><input id="password-confirm" type="password" class="w100" name="password_confirmation" required></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input id="team_token" type="text" class="w100" name="team_token" value="{{request('team_token')}}" required placeholder="INVITATION CODE">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <button type="submit" class="uppercase p2 center w100">Register</button>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
@endsection
