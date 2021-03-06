@extends('layouts.app')
@section('css')
<link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>
<link type="text/css" rel="stylesheet" href="../css/main.css"  media="screen,projection"/>
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="margin-top-100">
            <div class="col m6  white padding-none z-depth-3 offset-m3 s12">
                <h4 class="red margin-none padding-10 grey-text text-lighten-3 light">Reset Password</h4>
                <!-- <div class="panel-body"> -->
                <form  class="padding-15" method="POST" action="{{ url('/password/reset') }}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="email"  name="email" value="{{ old('email') }}" id="email" class="validate black-text">
                            <label class="black-text" for="email">E-Mail Address</label>
                            @if ($errors->has('email'))
                            <small class="red-text text-darken-3">{{ $errors->first('email') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="password"  name="password" id="password" class="validate black-text">
                            <label class="black-text" for="password">Password</label>
                            @if ($errors->has('password'))
                            <small class="red-text text-darken-3">{{ $errors->first('password') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="password"  name="password_confirmation" id="password_confirmation" class="validate black-text">
                            <label class="black-text" for="password_confirmation">Confirm Password</label>
                            @if ($errors->has('password_confirmation'))
                            <small class="red-text text-darken-3">{{ $errors->first('password_confirmation') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <button type="submit" class="btn red darken-2 grey-text text-lighten-4">Reset Password</button>
                        </div>
                    </div>
                </form>
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/materialize.min.js"></script>
<script type="text/javascript" src="../js/main.js"></script>
@stop