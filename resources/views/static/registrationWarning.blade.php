@extends("layouts.app")
@section("content")
<div class="row margin-none">
    <div class="col s12  margin-none padding-none">
        <div class="row padding-none margin-none">
            <div class="red darken-2 padding-none margin-none">
                <span class="title padding-none">
                    <a href="{{url('/')}}" class="grey-text text-lighten-3">
                        Book Barter Club
                    </a>
                </span>
                <small class="hide-on-med-and-down grey-text text-lighten-3 light" style='font-size:16px;padding-left:10px'>
                    Let your books relive....
                </small>
            </div>
        </div>
    </div>
    <div class="col s12 margin-none margin-top-15 padding-20 center-align">
        <h4 class="light margin-top-10 padding-top-20">{{$status_message}}</h4>
        <p class="center-align light margin-top-20 padding-top-20">Please click on the below button to go to <span class="red-text text-darken-2">homepage</span>  or to <span class="red-text text-darken-2">login</span></p>
        <a href="{{url('/')}}" class="btn z-depth-0 margin-top-10  center-align red darken-2 grey-text text-lighten-4">Home</a>
        <a href="{{url('/login')}}" class="btn z-depth-0 margin-top-10  center-align red darken-2 grey-text text-lighten-4">Login</a>
    </div>
</div>
@stop