@extends('layouts.app')
<!-- Main Content -->
@section('css')
<link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>
<link type="text/css" rel="stylesheet" href="../css/main.css"  media="screen,projection"/>
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="margin-top-100">
            <div class="col m6   offset-m3 s12">
                <!-- <div class="panel-body"> -->
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                <form  method="POST" role="form" class="card padding-15 yellow darken-2 z-depth-3" action="{{ url('/password/email') }}">
                    {!! csrf_field() !!}
                    <h6>Reset Password</h6>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            <label class="black-text" for="email">E-Mail Address</label>
                            @if ($errors->has('email'))
                            <small class="red-text text-darken-3">{{ $errors->first('email') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <button type="submit" class="btn white black-text btn-primary">
                            Send Password Reset Link
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- </div> -->
</div>
@endsection
@section('javascript')
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/materialize.min.js"></script>
<script type="text/javascript" src="../js/main.js"></script>
@stop