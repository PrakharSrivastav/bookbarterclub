@extends('layouts.profile')
@section('content')
<div class="row white padding-none margin-none margin-top-5 lighten-2" style="height:auto; overflow:hidden;min-height:400px">
    <div class="red darken-2 col s12">
        <h5 class="grey-text light text-lighten-4">Books Near You</h5>
    </div>
    <div class="col s12 white ">
        @if(count($suggestions) == 0)
            <h6 class="center-align  margin-top-10 light padding-5">Sorry,Could not find any books near you. Please check if you have setup your location</h6>
        @else
            @foreach($suggestions as $abook)
                <div class="col s12 m4 l3 margin-top-5 padding-10">
                    <div class="card  red darken-2 grey-text text-lighten-4 ">
                        <div class="card-image">
                            <img class="activator" height="180px" src="{{$abook['image']}}">
                        </div>
                        <div class="card-content padding-none margin-none" >
                            <span class="card-title padding-5 activator grey-text text-lighten-4 light "><i class="mdi-navigation-more-vert right"></i>{{ substr($abook['title'],0,12).".."}}</span>
                            <div class="light margin-top-5 padding-5">Distance : {{$abook['distance']}}</div>
                            <div class="padding-5 full-width">
                                <a class="btn btn-block white z-depth-0 red-text" href="{{route('user.show.books',['book_id'=>$abook['id']])}}">&nbsp;&nbsp;View Details&nbsp;&nbsp;</a>
                            </div>
                            <div style="clear:both"></div>
                        </div>
                        <div class="card-reveal row padding-none" style="overflow-x:hidden">
                            <div class="card-title col s12 activator red darken-2 padding-5 grey-text text-lighten-4"><i class="mdi-navigation-more-vert right"></i>{{substr($abook['title'],0,12).".."}}</div>
                            <div class="col s12 white black-text" style="height:227px">
                                <div class="padding-5 font-13">{{ strip_tags(substr($abook['desc'],0,100))."..." }}</div>
                                <div class="padding-5 font-13">Rating : {{$abook['rating']}}</div>
                            </div>
                            <a class="btn red darken-2 grey-text text-lighten-4" href="{{route('user.show.books',['book_id'=>$abook['id']])}}" style="position:absolute;bottom:7px;left:5px">&nbsp;&nbsp;View Details&nbsp;&nbsp;</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@stop