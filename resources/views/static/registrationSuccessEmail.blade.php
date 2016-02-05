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
        <h5 class="margin-top-10 padding-top-20 light">Your Account has been successfully registered on Book Barter Club</h5>
        <p class="center-align light margin-top-20 padding-top-20">
            We have sent you an activation email. Please click on the activation link in the email to activate your account and login.
        </p>
    </div>
</div>
@stop