@extends('layouts.profile')
@section('content')
<div class="col s12 padding-top-5 card large yellow darken-2" style="height:auto; overflow:hidden;min-height:400px">
    <div class="row">
        <div class="col s12 m3"><br>
            <img class="img-responsive full-width" height="280" src="{{$the_book->image}}" >
            <a href="" class="btn btn-block white black-text margin-top-5">Add To Wishlist</a>
        <a href="" class="btn btn-block white black-text margin-top-5">Lend It</a>
        <a href="" class="btn btn-block red darken-4 black-text margin-top-5">Buy It</a>
        </div>
        <div class="col s12 m9 weight-300">
            <h5 class="weight-300">{{$the_book->title}}</h5>
            <div>Rating :  {{ $the_book->rating}}</div>
            <div>Review Counts :  {{ $the_book->reviews}}</div>
            <div>Publisher :  {{ $the_book->publisher}}</div>
            <div>Author(s) :  {{ $the_book->author_name}}</div>
            @if(isset($the_book->subtitle))
            <div>Subtitle :  {{ $the_book->subtitle}}</div>
            @endif
            <div>ISBN/ISBN13 :  {{ $the_book->isbn}}</div>
            <hr>
            <p>
            {{$the_book->desc}}
            </p>
        </div>
    </div>
    <!-- <div class="row margin-top--5">
        <a href="" class="btn white black-text">Add To Wishlist</a>
        <a href="" class="btn white black-text">Lend It</a>
        <a href="" class="btn red darken-4 black-text">Buy It</a>
    </div> -->
</div>
<div class="col s12 padding-top-5 card large yellow darken-2" style="height:auto; ;min-height:400px">
    <div class="row">
        <h5 class="weight-300">People who are willing to lend / rent this book.</h5>
        <div class="row card padding-10">
            <div class="col s12 m2" >
                <div align="center">
                    @if(isset($owner->image))
                    <img class="img-responsive circle" width="200px" height="200px"  src="{{$owner->image}}" >
                    @else
                    <img class="img-responsive circle"  src="{{url('img/Man-14.svg')}}" >
                    @endif
                </div>
            </div>
            <div class="col s12 m7 weight-300">
                <div><strong>First Name : </strong><span> {{ucwords($owner->firstname)}}</span></div>
                <div><strong>Last Name : </strong><span> {{ucwords($owner->lastname)}}</span></div>
                <div><strong>Location : </strong><span> {{ucwords($owner->location_name)}}</span></div>
                <div><strong>Preferred Meeting Location : </strong><span> {{ucwords($owner->pref_location)}}</span></div>
                @if($owner->privacy == 1)
                <div><strong>Email Address : </strong><span> {{ucwords($owner->email)}}</span></div>
                <div><strong>Gender : </strong><span> {{ucwords($owner->gender == '0' ? 'Unknown':($owner->gender=='1')?'Male':'Female')}}</span></div>
                <div><strong>Date of Birth : </strong><span> {{ucwords($owner->dob)}}</span></div>
                @endif
            </div>
            <div class="col s12 m3" >
                <a class="btn btn-block yellow darken-2 margin-top-5 black-text">Borrow</a>
                <a class="btn btn-block yellow darken-2 margin-top-5 black-text">View User</a>
                <a class="btn btn-block yellow darken-2 margin-top-5 black-text">Option</a>
            </div>
        </div>
        @if(isset($other_users) && count($other_users) > 0)
        @foreach ($other_users as $other)
        <div class="row card padding-10">
            <div class="col s12 m2" >
                <div align="center">
                    @if(isset($other->image))
                    <img class="img-responsive circle" width="200px" height="200px"  src="{{$other->image}}" >
                    @else
                    <img class="img-responsive circle"  src="{{url('img/Man-14.svg')}}" >
                    @endif
                </div>
            </div>
            <div class="col s12 m7 weight-300">
                <div><strong>First Name : </strong><span> {{ucwords($other->firstname)}}</span></div>
                <div><strong>Last Name : </strong><span> {{ucwords($other->lastname)}}</span></div>
                <div><strong>Location : </strong><span> {{ucwords($other->location_name)}}</span></div>
                <div><strong>Preferred Meeting Location : </strong><span> {{ucwords($other->pref_location)}}</span></div>
                @if($other->privacy == 1)
                <div><strong>Email Address : </strong><span> {{ucwords($other->email)}}</span></div>
                <div><strong>Gender : </strong><span> {{ucwords($other->gender == '0' ? 'Unknown':($other->gender=='1')?'Male':'Female')}}</span></div>
                <div><strong>Date of Birth : </strong><span> {{ucwords($other->dob)}}</span></div>
                @endif
            </div>
            <div class="col m3 s12" >
                <a class="btn btn-block yellow darken-2 margin-top-5 black-text">Borrow</a>
                <a class="btn btn-block yellow darken-2 margin-top-5 black-text">View User</a>
                <a class="btn btn-block yellow darken-2 margin-top-5 black-text">Option</a>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
@stop