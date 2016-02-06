@extends("layouts.app")
<div class="row white margin-none">
    <div class="col s12 m8 margin-none padding-none">
        <div class="row white accent-4  padding-none margin-none">
            <div class="row red darken-2 padding-none margin-none">
                <span class="title padding-none"><a href="{{url('/')}}" class="grey-text text-lighten-3">Book Barter Club</a></span><small class="hide-on-med-and-down grey-text text-lighten-3 light" style='font-size:16px;padding-left:10px'>Let your books relive....</small>
            </div>
            <!-- <h4 class="center-align weight-300">We found below books matching your selection</h4> -->
            
        </div>
        @if(isset($valid_users))
        <div class="row ">
            <h5 class="center-align weight-300">We found below matches near your area</h5>
            <div class="center-align grey-text text-darken-3 padding-bottom-10">
                <span>By default we show only first 3 matches. To get more matches please <a href="{{url('/login')}}" class="red-text text-darken-2 light">[LOGIN]</a> OR <a  href="{{url('/register')}}" class="red-text text-darken-2 light">[REGISTER]</a> in our system.</span>
            </div>
            @foreach($valid_users as $users)
            <div class="col s12 m4 margin-top-5 padding-10">
                <div class="card  black-text margin-bottom-5 margin-top-none weight-300" style="min-height:150px">
                    <!-- <div class="card-content"> -->
                    <div class="padding-10 red grey-text text-lighten-3 font-16"><strong>{{$users['firstname']}}</strong> </div>
                    <div class="card-title row margin-top-10">
                        <strong class="col s3">Location</strong> 
                        <div class="col s9">{{$users['location_name']}}</div>
                    </div>
                    <div class="card-title row ">
                        <strong class="col s3">Distance</strong> 
                        <div class="col s9">{{$users['distance']}} Km</div>
                    </div>
                    <div style="clear:both"></div>
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
            <div class="col s6 m2 margin-top-5 padding-10">
                <div class="card padding-none margin-none">
                    <div class="card-image">
                        <img class="activator" src="{{$books['image']}}" height="180px">
                        @if($books['image'] == 'https://s.gr-assets.com/assets/nophoto/book/111x148-bcc042a9c91a29c1d680899eff700a03.png')
                        <div class="card-title activator black-text" style="position:absolute;top:-10px;left:-15px">{{$books['title']}}</div>
                        @endif
                    </div>
                    <div class="card-content grey lighten-2 padding-none margin-none">
                        <div class="card-title light font-12 activator red darken-2 padding-5 grey-text text-lighten-4"><i class="mdi-navigation-more-vert right"></i>{{substr($books['title'],0,12).".."}}</div>
                        <div class="padding-5 font-12">Distance : {{$books['distance']}}</div>
                        <div class="padding-5 font-12">Rating : {{$books['rating']}}</div>
                    </div>
                    <div class="card-reveal grey lighten-2 padding-none">
                        <span class="card-title grey-text red darken-2 padding-5 text-lighten-4 font-12"><i class="mdi-hardware-keyboard-arrow-down right"></i>{{$books['title']}}</span>
                        <div class="font-12 light padding-5" >{{strip_tags(substr($book->desc,0,150)).".."}}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
    <div class="col s12 m4 card-panel margin-none padding-none">
        @if(isset($book))
        <div class="margin-none weight-300" id="book_results">
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
                <span class="teaser" >{{strip_tags(substr($book->desc,0,250))}}</span>
                <span class="complete"  >{{ strip_tags($book->desc) }}</span>
                <a href="" class="more red-text text-darken-2 weight-400"><br>Show More...</a>
                </p>
                @else
                <p>{{ strip_tags($book->desc) }}</p>
                @endif
                
                </p>
                
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