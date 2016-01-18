@extends("layouts.app")
<div class="row amber accent-4  margin-none">

    <div class="col s12 m8 margin-none padding-none">
        <div class="row amber accent-4  padding-none margin-none">
            <h3 class="center-align weight-300"> We found below books matching your selection</h3>
            <div class="center-align grey-text text-darken-3 padding-bottom-10">
                <span>By default we show only first 3 matches. To get more matches please register in our system.</span>
            </div>
        </div>
        @if(isset($valid_users))
        <div class="row ">
            <h5 class="center-align weight-300">We found below matches near your area</h5>
            @foreach($valid_users as $users)
            <div class="col s12 m4 margin-top-5 padding-10">
                <div class="card  black-text  padding-10 margin-bottom-5 margin-top-none white weight-300" style="min-height:150px">
                    <!-- <div class="card-content"> -->
                    <div class="card-title padding-10"><strong>User : </strong> {{$users['firstname']}}</div>
                    <div class="card-title padding-10"><strong>Distance : </strong> {{$users['distance']}} Km</div>
                    <div class="card-title padding-10"><strong>Location : </strong> {{$users['location_name']}}</div>
                    <div style="cleab:both"></div>
                    <!-- </div> -->
                </div>
            </div>
            @endforeach
        </div>
        @endif
        @if(isset($suggestions))
        <div class="row ">
            <h5 class="center-align weight-300">More books near your area</h5>
            @foreach($suggestions as $books)
            <div class="col s6 m3 margin-top-5 padding-10">
                <div class="card  yellow lighten-2 small padding-none margin-none">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="{{$books['image']}}">
                    </div>
                    <div class="card-content">
                        <span class="card-title weight-400 activator grey-text text-darken-4"><i class="mdi-navigation-more-vert right"></i>{{$books['title']}}</span>
                        <div class="weight-300 margin-top-5">Distance : {{$books['distance']}}</div>
                        <div class="weight-300 margin-top-5">Rating : {{$books['rating']}}</div>
                    </div>
                    <div class="card-reveal  yellow lighten-2">
                        <span class="card-title grey-text text-darken-4"><i class="mdi-hardware-keyboard-arrow-down right"></i>{{$books['title']}}</span>
                        <hr/>
                        
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
    <div class="col s12 m4 margin-none padding-none">
        @if(isset($book))
        <div class="card-panel margin-none white weight-300" id="book_results">
            <h5 class="center-align padding-top-10 weight-300 padding-bottom-10">{{$book->title}}</h5>
            <div class="col s3">
                <img src="{{$book->image}}" class="full-width">
            </div>
            <div class="col s9 padding-none">
                <div class="left-align"><strong>Author : </strong>{{$book->author_name}}</div>
                <div class="left-align"><strong>Publisher : </strong>{{$book->publisher}}</div>
                <div class="left-align"><strong>ISBN / ISBN13 : </strong>{{$book->isbn}}</div>
                <div class="left-align"><strong>Ratings : </strong>{{$book->rating}}</div>
                <div class="left-align"><strong>Reviews : </strong>{{$book->reviews}}</div>
            </div>
            <div class="col s12 padding-10">
                @if(strlen($book->desc)>250)
                <p>
                <span class="teaser" >{{substr($book->desc,0,250)}}</span>
                <span class="complete"  >{!! $book->desc !!}</span>
                <a href="" class="more blue-text text-darken-2 weight-400"><br>Show More...</a>
                </p>
                @else
                <p>{!! $book->desc !!}</p>
                @endif
                </p>
                <div style="clear:both"></div>
            </div>
            <div style="clear:both"></div>
        </div>
        @endif
    </div>
</div>
@section('javascript')
<script>
$(".complete").hide();
$(".more").click(function(e){
    e.preventDefault();
    el = $(this);
    if(el.hasClass('text-darken-2')){
        el.removeClass('text-darken-2');
        el.addClass('text-darken-3');
        $(this).html("<br>Show Less ....");
    }
    else{
        el.removeClass('text-darken-3');
        el.addClass('text-darken-2');
        $(this).html("<br>Show More ....");
    }
    $(".teaser").toggle();
    $(".complete").slideToggle(400);
})
</script>
@stop