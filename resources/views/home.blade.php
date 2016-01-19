@extends('layouts.profile')
@section('css')
<link type="text/css" rel="stylesheet" href="{{url('css/google.style.css')}}"  media="screen,projection"/>
@stop
@section('content')
<ul class="collapsible z-depth-0" data-collapsible="accordion">
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