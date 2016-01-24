@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row ">
        <div class="margin-top-60">
            <div class="col m6 push-m3 s12 card padding-none">
                <h4 class="red margin-none padding-10 grey-text text-lighten-3 light">Register</h4>
                <form id="registration_form" class="padding-15 white z-depth-3" role="form" method="POST" action="{{ url('/register') }}">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="input-field col s12">
                            <input  required="" type="text"  name="name" value="{{ old('name') }}" id="name" class="validate black-text">
                            <label class="black-text" for="name">Name (How would you like to be called) </label>
                            @if ($errors->has('name'))
                            <small class="red-text text-darken-3">{{ $errors->first('name') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input  required="" type="email"  name="email" value="{{ old('email') }}" id="email" class="validate black-text">
                            <label class="black-text" for="email">E-Mail Address</label>
                            @if ($errors->has('email'))
                            <small class="red-text text-darken-3">{{ $errors->first('email') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input  required="" type="password"  name="password" id="password" class="validate black-text">
                            <label class="black-text" for="password">Password</label>
                            @if ($errors->has('password'))
                            <small class="red-text text-darken-3">{{ $errors->first('password') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input  required="" type="password"  name="password_confirmation" id="password_confirmation" class="validate black-text">
                            <label class="black-text" for="password_confirmation">Confirm Password</label>
                            @if ($errors->has('password_confirmation'))
                            <small class="red-text text-darken-3">{{ $errors->first('password_confirmation') }}</small>
                            @endif
                        </div>
                    </div>
                    <p>
                    <input type="submit" class="btn red darken-2 grey-text text-lighten-3" value="Register">
                    </p>
                </form>
            </div>
        </div>
    </div>
    @endsection
    @section('javascript')
<script type="text/javascript" src="js/app.validate.js"></script>
@stop