@extends('layouts.profile')
@section('css')
<link type="text/css" rel="stylesheet" href="{{url('css/google.style.css')}}"  media="screen,projection"/>
@stop
@section('content')
<ul class="collapsible " data-collapsible="accordion">
    <li class="margin-top-5">
        <div class="collapsible-header margin-top-5 yellow darken-2"><i class="material-icons">book</i>My Books <small class='right weight-400'>Add Books to your profile</small></div>
        <div class="collapsible-body white  min-height-350 padding-10">
            <div class="chip yellow darken-2 black-text weight-300">
                Number of books : {{count($my_books)}}
            </div>
            <div class="chip yellow darken-2 right">
                <a class="black-text weight-300" href="{{route('user.get.books',[$user->id])}}">Add More Books</a>
            </div>
            @if(count($my_books) < 1)
            <p>You have not added any books. Please add books to your profile.</p>
            @else
            <div>
                @if(isset($my_books) && count($my_books)>0)
                <div class="row">
                    <h5>My Books</h5>
                    @foreach($my_books as $book)
                    @if($book->is_lendable == '1')
                    <div class="col s6 m2">
                        <div class="card hoverable">
                            <div class="card-image">
                                <img class="activator" width="auto" height="180px" src="{{$book->image}}">
                            </div>
                            <div class="card-title padding-5 yellow darken-2">
                                <a class="black-text">{{substr($book->title,0,10).".."}}</a>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                <hr/>
                <div class="row">
                    <h5>My wishLlist</h5>
                    @foreach($my_books as $book)
                    @if($book->is_wishlist == '1')
                    <div class="col s6 m2">
                        <div class="card hoverable">
                            <div class="card-image">
                                <img class="activator" width="auto" height="180px" src="{{$book->image}}">
                            </div>
                            <div class="card-title padding-5 yellow darken-2">
                                <a class="black-text">{{substr($book->title,0,10).".."}}</a>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                @endif
            </div>
            @endif
        </div>
    </li>
    <li>
        <div class="collapsible-header margin-top-5 yellow darken-2 "><i class="material-icons">perm_identity</i>My Profile <small class='weight-400 right'>View profile details</small></div>
        <div class="collapsible-body white padding-10">
            <div class="chip yellow darken-2 weight-300 black-text left">
                {{$user->name}}
            </div>
            <div class="chip yellow darken-2 weight-300 black-text right">
                <a href="{{route('user.edit',[$user->id])}}" class="black-text">Edit Profile</a>
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
                        <div class="col s4 m2">Books count</div><div class="col s8 m10">{{ empty($user->book_num)?"0":$user->book_num}}&nbsp; books so far</div>
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
    </li>
    
    <li>
        <div class="collapsible-header yellow margin-top-5  darken-2"><i class="material-icons">view_carousel</i>My Stories <small class="right weight-400">List of published stories</small></div>
        <div class="collapsible-body white  min-height-350"><p>Lorem ipsum dolor sit amet.</p></div>
    </li>
    <li>
        <div class="collapsible-header yellow darken-2 margin-top-5 active"><i class="material-icons">room</i>My Location <small class='right weight-400'>{{ (empty($user->longitude) || (empty($user->latitue)))?'Setup / Edit your location':''}}</small></div>
        <div class="collapsible-body white  min-height-350 padding-10">

            <div class="chip yellow darken-2 weight-300 black-text">
                <span class="currentLocation">{{$user->location_name}}</span>
            </div>
            <div class="chip yellow darken-2 weight-300 black-text right">
                <a href="" id="saveLocation" class="black-text">Save New Location</a>
            </div>
            <br/><br/>
            <div>
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
        // console.log(locName , locCoord);
        var flag = true;
        message = [];
        if(locName == "" || locName == undefined){
            message.push("Please provide the location in the map");
            flag = false;
            if(locCoord == "" || locCoord == undefined){
                message.push("Please provide the location coordinate");
                flag = false;
            }
        }
        if (flag){
            $.ajax({
            type: "POST",
            url: "{{route('savemap')}}",
            data: {user:{{$user->id}},name:locName,location:locCoord,_token:"{{csrf_token()}}"},
            success: function(a,b,c){
                if(a !== false && a.status == 100){
                    $(".currentLocation").empty().text(a.location_name);
                }
            },
            dataType: "json",
            error : function(a,b,c){
                console.log("Invalid session token. Invalid request");
            }
            });
        }
        else{
            console.log("flag is false");
        }
    });
});
</script>
@stop