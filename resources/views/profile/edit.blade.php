@extends("layouts.profile")
@section('content')
<div class="row white padding-none margin-top-10">
    <div  class="col white s12 padding-none">
        <table class="responsive-table striped bordered">
            <caption class="red darken-2 grey-text text-lighten-4 padding-5 weight-400 left-align">Profile Details</caption>
            <tbody id="profile_table" class="padding-none white ">
                <tr>
                    <td style="width:30%">Name</td>
                    <td>{{ empty($user->name)?"--":$user->name}}</td>
                </tr>
                <tr>
                    <td>Surname</td>
                    <td>{{ empty($user->lastname)?"--":$user->lastname}}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{ empty($user->email)?"--":$user->email}}</td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>{{ empty($user->gender)?"--":$user->gender}}</td>
                </tr>
                <tr>
                    <td>About</td>
                    <td>{{ empty($user->about)?"--":$user->about}}</td>
                </tr>
                <tr>
                    <td>Birthday</td>
                    <td>{{ empty($user->dob)?"--":$user->dob}}</td>
                </tr>
                <tr>
                    <td>Fav Quote</td>
                    <td>{{ empty($user->fav_quote)?"--":$user->fav_quote}}</td>
                </tr>
                <tr>
                    <td>Mobile</td>
                    <td>{{ empty($user->contact_num)?"--":$user->contact_num}}</td>
                </tr>
                <tr>
                    <td>Contact</td>
                    <td>{{ empty($user->mobile_num)?"--":$user->mobile_num}}</td>
                </tr>
                <tr>
                    <td>Pref location</td>
                    <td>{{ empty($user->pref_location)?"--":$user->pref_location}}</td>
                </tr>
                <tr>
                    <td>Address</td><td class="currentLocation">{{ empty($user->location_name)?"--":$user->location_name}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row white">
    <form id="edit_profile_form" class="margin-top--10 z-depth-0" role="form" method="POST" action="{{route('user.update',[$user->id])}}">
        <input type="hidden" name="_method" value="PUT">
        {!! csrf_field() !!}
        <h6 class="red darken-2 padding-10 grey-text text-lighten-4" >Edit Profile details</h6>
        <div class="row">
            <div class="input-field col s6">
                <input  type="text"  name="firstname" value="{{$user->name}}" id="firstname" class="validate black-text">
                <label class="black-text" for="firstname">Firstname</label>
                @if($errors->has('firstname'))
                <small class="red-text text-darken-3">{{ $errors->first('firstname') }}</small>
                @endif
            </div>
            <div class="input-field col s6">
                <input  type="text"  name="lastname" value="{{$user->lastname}}" id="lastname" class="validate black-text">
                <label class="black-text" for="lastname">Lastname</label>
                @if(isset($errors) && $errors->has('lastname'))
                <small class="red-text text-darken-3">{{ $errors->first('lastname') }}</small>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <select name='gender' id='gender'>
                    <option value="0" {{($user->gender == '0')?'selected':''}}>Choose your option</option>
                    <option value="1" {{($user->gender == '1')?'selected':''}}>Male</option>
                    <option value="2" {{($user->gender == '2')?'selected':''}}>Female</option>
                </select>
                <label>Your gender</label>
                @if(isset($errors) && $errors->has('gender'))
                <small class="red-text text-darken-3">{{ $errors->first('gender') }}</small>
                @endif
            </div>
            <div class="input-field col s6">
                <textarea id="about" name='about' rows='2' class="materialize-textarea padding-none">{{$user->about}}</textarea>
                <label for="about">About You</label>
                @if(isset($errors) && $errors->has('about'))
                <small class="red-text text-darken-3">{{ $errors->first('about') }}</small>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <input type="text" name='dob' value='{{$user->dob}}' class="datepicker">
                <label class="black-text" for="dob">Date Of Birth</label>
                @if(isset($errors) && $errors->has('dob'))
                <small class="red-text text-darken-3">{{ $errors->first('dob') }}</small>
                @endif
            </div>
            <div class="input-field col s6">
                <textarea id="fav_quote" name='fav_quote' rows='2' class="materialize-textarea padding-none">{{$user->fav_quote}}</textarea>
                <label for="fav_quote">Favourite Quote</label>
                @if(isset($errors) && $errors->has('fav_quote'))
                <small class="red-text text-darken-3">{{ $errors->first('fav_quote') }}</small>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <input type="text" name='contact_num' value='{{$user->contact_num}}' class="validate black-text">
                <label class="black-text" for="contact_num">Contact Number</label>
                @if(isset($errors) && $errors->has('contact_num'))
                <small class="red-text text-darken-3">{{ $errors->first('contact_num') }}</small>
                @endif
            </div>
            <div class="input-field col s6">
                <input type="text" name='mobile_num' value='{{$user->mobile_num}}' class="validate black-text">
                <label class="black-text" for="mobile_num">Mobile Number</label>
                @if(isset($errors) && $errors->has('mobile_num'))
                <small class="red-text text-darken-3">{{ $errors->first('mobile_num') }}</small>
                @endif
            </div>
        </div>
        <p class="padding-left-15">
            <input type="checkbox" name="private" id="private" checked class="black black-text" />
            <label for="private" class="black-text">Show my contact information to other users.</label>

        </p>
        
        <p class="padding-15">
            <input type="submit" class="btn margin-10 red darken-2 grey-text text-lighten-4" value="Save">
        </p>
    </form>
</div>

@stop