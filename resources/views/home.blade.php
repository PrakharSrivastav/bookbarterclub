@extends('layouts.profile')
@section('css')
<link type="text/css" rel="stylesheet" href="{{url('css/google.style.css')}}"  media="screen,projection"/>
@stop
@section('content')
<ul class="collapsible z-depth-0" data-collapsible="accordion">
    <!-- <li class="margin-top-5">
        <div class="collapsible-header margin-top-5 grey lighten-2 "><i class="material-icons">book</i>My Books <small class='right weight-400'>Add Books to your profile</small></div>
        <div class="collapsible-body grey lighten-2  min-height-350 padding-10">
            <div class="row">
                @if(isset($in_stock) && isset($wish_list))
                <div class="padding-5 amber left accent-4 s12 black-text weight-300">
                    {{count($in_stock)}} in stock , {{count($wish_list)}} in wishlist
                </div>
                @endif
                <div class="padding-5 amber accent-4 s12 right">
                    <a class="black-text weight-300" href="{{route('user.getuser.books')}}">Add /Edit Your Books</a>
                </div>
            </div>
            @if(isset($in_stock) && isset($wish_list))
            @if(count($in_stock)+count($wish_list) < 1)
            <p>You have not added any books. Please add books to your profile.</p>
            @else

            <div>
                
                <div class="row">
                    <h5>My Books</h5>
                    @if(isset($in_stock))
                    @foreach($in_stock as $book)
                    @if($book->is_lendable == '1')
                    <div class="col s6 m2">
                        <div class="card hoverable">
                            <div class="card-image">
                                <img class="activator" width="auto" height="180px" src="{{$book->image}}">
                            </div>
                            <div class="card-title padding-5 yellow">
                                <a class="black-text">{{substr($book->title,0,10).".."}}</a>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    
                </div>
                <hr/>
                @endif
                @if(isset($wish_list))
                <div class="row">
                    <h5>My wishLlist</h5>
                    @foreach($wish_list as $book)
                    @if($book->is_wishlist == '1')
                    <div class="col s6 m2">
                        <div class="card hoverable">
                            <div class="card-image">
                                <img class="activator" width="auto" height="180px" src="{{$book->image}}">
                            </div>
                            <div class="card-title padding-5 yellow">
                                <a class="black-text">{{substr($book->title,0,10).".."}}</a>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                @endif
                @endif
            </div>
            @endif
        </div>
    </li>
     --><!-- <li>
        <div class="collapsible-header margin-top-5 grey lighten-2  "><i class="material-icons">perm_identity</i>My Profile <small class='weight-400 right'>View profile details</small></div>
        <div class="collapsible-body grey lighten-2 padding-10 weight-300">
            <div class="row">
                <div class="grey lighten-2 padding-5 left  black-text">
                    {{$user->name}}
                </div>
                <div class="grey lighten-2  padding-5 black-text right">
                    <a href="{{route('user.edit.profile')}}" class="black-text">Edit Profile</a>
                </div>
            </div>
            <div class="row padding-10 weight-300">
                <div  class="col s12">
                    <div class="row padding-none margin-none">
                        <div class="col s4 m2">Name</div><div class="col s8 m10 ">{{ empty($user->firstname)?"--":$user->firstname}}</div>
                    </div>
                    <div class="row  padding-none margin-none">
                        <div class="col s4 m2">Surname</div><div class="col s8 m10">{{ empty($user->lastname)?"--":$user->lastname}}</div>
                    </div>
                    <div class="row  padding-none margin-none">
                        <div class="col s4 m2">Email</div><div class="col s8 m10">{{ empty($user->email)?"--":$user->email}}</div>
                    </div>
                    <div class="row  padding-none margin-none">
                        <div class="col s4 m2">Gender</div><div class="col s8 m10">{{ empty($user->gender)?"--":$user->gender}}</div>
                    </div>
                    <div class="row  padding-none margin-none">
                        <div class="col s4 m2">About</div><div class="col s8 m10">{{ empty($user->about)?"--":$user->about}}</div>
                    </div>
                    <div class="row  padding-none margin-none">
                        <div class="col s4 m2">Birthday</div><div class="col s8 m10">{{ empty($user->dob)?"--":$user->dob}}</div>
                    </div>
                    <div class="row  padding-none margin-none">
                        <div class="col s4 m2">Fav Quote</div><div class="col s8 m10">{{ empty($user->fav_quote)?"--":$user->fav_quote}}</div>
                    </div>
                    <div class="row  padding-none margin-none">
                        @if(isset($in_stock) && isset($wish_list)))
                        <div class="col s4 m2">Books count</div><div class="col s8 m10">{{count($in_stock)}}&nbsp; books in Stock , {{count($wish_list)}} in wishlist</div>
                        @endif
                    </div>
                    <div class="row  padding-none margin-none">
                        <div class="col s4 m2">Mobile</div><div class="col s8 m10">{{ empty($user->contact_num)?"--":$user->contact_num}}</div>
                    </div>
                    <div class="row  padding-none margin-none">
                        <div class="col s4 m2">Contact</div><div class="col s8 m10">{{ empty($user->mobile_num)?"--":$user->mobile_num}}</div>
                    </div>
                    <div class="row  padding-none margin-none">
                        <div class="col s4 m2">Pref location</div><div class="col s8 m10">{{ empty($user->pref_location)?"--":$user->pref_location}}</div>
                    </div>
                    <div class="row  padding-none margin-none">
                        <div class="col s4 m2">Address</div><div class="col s8 m10 currentLocation">{{ empty($user->location_name)?"--":$user->location_name}}</div>
                    </div>
                </div>
            </div>
        </div>
    </li> -->
    <!-- <li>
                                                <div class="collapsible-header grey lighten-2  margin-top-5"><i class="material-icons">view_carousel</i>My Stories <small class="right weight-400">List of published stories</small></div>
                                                <div class="collapsible-body grey lighten-2  min-height-350"><p>Lorem ipsum dolor sit amet.</p></div>
    </li> -->
    <li>
        <div class="collapsible-header grey lighten-2  margin-top-5 active"><i class="material-icons">room</i>My Location <small class='right weight-400'>{{ (empty($user->longitude) || (empty($user->latitue)))?'Setup / Edit your location':''}}</small></div>
        <div class="collapsible-body grey lighten-2  min-height-350 padding-10">
            <div class="row no-margin no-padding">
                <span class="currentLocation grey lighten-2 padding-5 left">{{$user->location_name}}</span>
                <a href="" id="saveLocation" class="grey lighten-2 padding-5 right black-text">Save</a>
            </div>
            <div class="row no-margin no-padding">
                <input id="pac-input" class="controls" type="text" placeholder="Search Box" style="margin-top:5px">
                <div  id="map" style="height:400px"></div>
            </div>
        </div>
    </li>
</ul>
@endsection
@section('javascript')
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWQggw-OmClnyma5MoBfzCnKmA7exSqtQ&libraries=places&callback=initAutocomplete"></script>
<script type="text/javascript" src="{{url('js/google.style.js')}}"></script>
<script>
$(document).ready(function($) {
    $("#pac-input").val("");
    $("#saveLocation").click(function(e){
        e.preventDefault();
        locName = $("#pac-input").val();
        locCoord = loc;
        var flag = true;
        message = [];
        if(locName == "" || locName == undefined || locCoord == "" || locCoord == undefined){
            Materialize.toast("Please provide the location in the map", 5000);
            flag = false;
        }
        if (flag){
            $.ajax({
                type: "POST",
                url: "{{route('savemap')}}",
                data: {user:{{$user->id}},name:locName,location:locCoord,_token:"{{csrf_token()}}"},
                success: function(a,b,c){
                    if(a !== false && a.status == 100){
                        $(".currentLocation").empty().text(a.location_name);
                        location_mine = a.location_name;
                    }
                },
                dataType: "json",
                error : function(a,b,c){
                    Materialize.toast("Invalid session token. Invalid request", 5000);
                }
            });
        }
    });
});
</script>
@stop