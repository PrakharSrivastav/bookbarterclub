@extends("layouts.profile")
@section('content')
<div class="row white padding-none margin-top-10">
    <div  class="col white s12 padding-none">
        <table class="responsive-table striped bordered">
            <caption class="red darken-2 grey-text text-lighten-4 padding-5 weight-400 left-align">Profile Details</caption>
            <tbody id="profile_table" class="padding-none white ">
                <tr class="margin-none padding-none">
                    <td class="padding-none margin-none ">
                    @if(isset($user->img_path) && $user->img_path != "")
                        <img id="user_image" src="{{$user->img_path}}" class="img-responsive margin-none full-width padding-none"></td>
                    @else
                        <img id="user_image" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTn-1U56BaY8TOMYjIGxw6DLiZ5BeX0-EXj6a8JJ8veCUfv6G2N" class="img-responsive margin-none full-width padding-none"></td>
                    @endif
                    <td class="center-align">
                        <form id="imageUploadForm" enctype="multipart/form-data" method="post">
                            {!! csrf_field() !!}
                            <input type='file' name="file" id="file" style='width: 0.1px;height: 0.1px;opacity: 0;overflow: hidden;position: absolute;z-index: -1;'>
                            <label for="file" class="btn red darken-2 grey-text text-lighten-4 margin-15" style="margin-right:30px">Choose a file</label>
                            <button type='submit' id="upload-file" class="btn margin-left-15 red darken-2 grey-text text-lighten-4">save Profile Image</button>
                        </form>
                    </td>
                </tr>
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
@section("javascript")
<script>
    $(document).ready(function($) {
        $("#imageUploadForm").submit(function(event) {
            event.preventDefault();
            file_is = $("#file").val();
            console.log(file_is);
            if(file_is == "" || file_is == undefined){
                alert("Please select an image to upload");
                return false;
            }
            else{
                file_ext = file_is.split(".");
                file_ext = file_ext[file_ext.length-1].toLowerCase();
                if($.inArray(file_ext, ["gif","jpg","jpeg","gif","bmp","png"]) == -1){
                    alert('Please select an image. The file type should be in ["gif","jpg","jpeg","gif","bmp","png"]');
                    return false;
                }
                // image_data = nameew FormData($("#imageUploadForm"));
                
                $.ajax({
                    url: "{{route('uploadUserImage')}}",
                    type: 'POST',
                    contentType: false,
                    cache: false,
                    processData:false,
                    data: new FormData(this),
                })
                .done(function(a) {
                    console.log(a);
                    console.log("success");
                    if(a !== false){
                        $("#user_image").attr('src', a);
                    }
                })
                .fail(function() {
                    console.log("error");
                })
                .always(function() {
                    console.log("complete");
                });
                
            }
            
            
            
            ;
        });   
    });
</script>
@stop