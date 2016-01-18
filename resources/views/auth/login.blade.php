@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row ">
        <div class="margin-top-100">
            <div class="col m6 offset-m3 s12">
                <form id="login_form" class="card z-depth-3 padding-15 white" role="form" method="POST" action="{{ url('/login') }}">
                    {!! csrf_field() !!}
                    <h6>Login</h6>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="mdi-communication-email prefix"></i>
                            <input type="email"  name="email" value="{{ old('email') }}" id="email" class="validate white black-text" required="">
                            <label for="email">E-Mail Address</label>
                            @if ($errors->has('email'))
                            <small class="red-text text-darken-3">{{ $errors->first('email') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="mdi-communication-vpn-key prefix"></i>
                            <input type="password"  name="password" id="password" class="validate"  required="">
                            <label for="password">Password</label>
                            @if ($errors->has('password'))
                            <small class="red-text text-darken-3">{{ $errors->first('password') }}</small>
                            @endif
                        </div>
                    </div>
                    <p>
                    <input type="checkbox" name="remember" id="remember" />
                    <label for="remember" class="black-text">Remember Me</label>
                    </p>
                    <p>
                    <button type="submit" id="submit_login_form" class="btn z-depth-0 amber black-text">Login</button>
                    <a class="right small black-text" href="{{ url('/password/reset') }}">Forgot Password?</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
    @endsection
    @section('javascript')
    <script>
        $("#password").val("");
        $("#password").focus();
    </script
    <script type="text/javascript" src="js/app.validate.js"></script>
    @stop