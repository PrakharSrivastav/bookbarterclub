@extends("layouts.app")
@section('css')
<link type="text/css" rel="stylesheet" href="{{url('css/owl.css')}}"  media="screen,projection"/>
<link type="text/css" rel="stylesheet" href="{{url('css/google.style.css')}}"  media="screen,projection"/>
@stop
@section("content")
<div class="row padding-none margin-none">
    <div class="col s12 m8 padding-none z-depth-0">
        <div class="row red darken-2 padding-none margin-none" >
            <span class="title padding-none"><a href="{{url('/')}}" class="grey-text text-lighten-4">Book Barter Club</a></span><small class="hide-on-med-and-down light grey-text text-lighten-4" style='font-size:16px;padding-left:10px'>Let your books relive....</small>
       <br/>
        </div>
        <div class="row white padding-5 margin-none center-align">
            <a href="{{url('/login')}}" class="btn-flat red-text text-darken-2">[ Login ]</a>
            <a href="{{url('/register')}}" class="btn-flat  red-text text-darken-2">[ Register ]</a>
        </div>
        <div class="row white black-text padding-15 margin-none" >
            <div class="left-align light font-20">
                Book Barter Club is an online book club that helps you exchange, borrow and lend books with other book lover in your neighbourhood for free. It's really easy to use and you can get started in 4 easy steps.
            </div>
        </div>
        <div class="row light white margin-none padding-10 font-18">
            <ul class="margin-none">
                <li>
                    1.&nbsp;&nbsp;<a href="{{url('/register')}}" class="red-text text-darken-2">Register </a> yourself on [ Book Barter Club ].
                </li>
                <li>
                    2.&nbsp;&nbsp;Save your best address.
                </li>
                <li>
                    3.&nbsp;&nbsp;Search for your favourite title.
                </li>
                <li>
                    4.&nbsp;&nbsp;Meet other book owners around you and barter your books.
                </li>
            </ul>
            <!-- <div class="center-align"><small class="">Save your location on right and search for your book</small></div> -->
        </div>
        <div class="row light white margin-none padding-10 font-16">
            To see a demo please save your location in the map on the right side and search for a book title in the next tab.
        </div>
        <div class="row  white black-text padding-none margin-none">
            @if(count($books) > 0)
            <br/>
            <!-- red darken-2 grey-text text-lighten-4 -->
            <div class="center-align light font-20 padding-5 red-text text-darken-2">Trending Books</div>
            <div id="owl-demo" style="padding:10px 8px 0px 8px">
                @foreach($books as $book)
                <div class="item col s12 l12" style="margin-left:-8px">
                    <div class="card hoverable orange lighten-2">
                        <div class="card-image">
                            <img class="activator" height="200px" src="{{$book->image}}">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
    <div class="col s12 m4">
        <ul class="collapsible" data-collapsible="accordion">
            <li>
                <div class="collapsible-header red darken-2 active margin-top-5 grey-text text-lighten-4"><i class="material-icons">place</i>1. Save Your Location</div>
                <div class="collapsible-body white">
                    <input id="pac-input" class="controls" type="text" placeholder="Search your location here..." style="margin-top:5px">
                    <div  id="map" style="height:400px"></div>
                </div>
            </li>
            <li>
                <div class="collapsible-header red grey-text text-lighten-4 darken-2 margin-top-5"><i class="material-icons">book</i>2. Search Your Favourite Title</div>
                <div class="collapsible-body white ">
                    <form>
                        <div class="input-field">
                            <input id="search" class="search " type="search"  style="margin-top:-15px" required placeholder="Search your book...">
                            <i class="material-icons" style="margin-top:10px">close</i>
                        </div>
                        <div id="result" class="results collection" style="z-index: 1000;margin-top: -15px;height:360px;overflow-y:auto">
                        </div>
                        <input type="hidden" id="guess">
                    </form>
                </div>
            </li>
            <li>
                <div class="collapsible-header red darken-2 margin-top-5 grey-text text-lighten-4"><i class="material-icons">info_outline</i>About Us </div>
                <div class="collapsible-body white  weight-300">
                    <div  style="height:400px;overflow-y:auto;padding:30px">
                       Book Barter Club is an attempt to bring back to life all the books that have been gathering dust on the bookshelf or have been packed in a carton box, or have been stocked in the garage never to be read by anyone.
                        Book Barter Club is an attempt to build a community of learned people who believe that knowledge is power and that sharing is caring. That a single copy of a book can be read by a million readers and yet there will be one more person to borrow it and one more to lend it.
                        For the love of books and for the love of free sharing of knowledge, Book Barker Club is an attempt to bring out all books into circulation so that there is a library in every neighbourhood.
                        <br/>
                        Create your own Book Barker Club library online and let books be exchanged freely.
                        In your attempt to exchange books, you will get a chance to meet new and like-minded people helping you build your circle of friends beyond FB and other social sites. Through BBC we hope we will be able to break free from the clutches of being hooked on to our laptops and phones and meet real people and share real stories.
                        After all that’s what books do….help to share some stories.
                        Share a book, meet new people, share some stories…
                    </div>
                </div>
            </li>
            <input type="hidden" id="csrf_t" name="_token" value="<?php echo csrf_token(); ?>">
            <li>
                <div class="collapsible-header red grey-text text-lighten-4 darken-2 margin-top-5"><i class="material-icons">message</i>Contact Us</div>
                <div class="collapsible-body white padding-15">
                    <form id="contact_us_form" class="row padding-none" action="{{route('contact')}}" method="post">    
                        <div id="error" class="col s12 red-text text-darken-1"></div>
                        <div class="input-field col s12 padding-none">
                            <input id="name" name="name" type="text" class="validate padding-none">
                            <label for="name">Name</label>
                        </div>
                        <div class="input-field col s12 padding-none">
                            <input id="email" name="email" type="text" class="validate padding-none">
                            <label for="email">Email</label>
                        </div>
                        <div class="input-field col s12 padding-none">
                            <textarea id="message" name="message" rows='5' class="materialize-textarea padding-none"></textarea>
                            <label for="message">Your Message</label>
                        </div>
                        <input type="submit" class="red darken-1 btn-large  btn-block  " value="Send">
                    </form>
                </div>
            </li>
        </ul>
    </div>
</div>
<footer class="page-footer padding-none margin-none red darken-2">
    <div class="footer-copyright">
        <div class="container">
            © 2016 : Book Barter Club
            <a class="margin-top-5 padding-5 right"  href="#!"><img alt="social media" src="{{url('img/facebook.svg')}}"></a>
            <a class="margin-top-5 padding-5 right"  href="#!"><img alt="social media" src="{{url('img/google.svg')}}"></a>
            <a class="margin-top-5 padding-5 right"  href="#!"><img alt="social media" src="{{url('img/twitter.svg')}}"></a>
        </div>
    </div>
</footer>
@stop
@section('javascript')
<script type="text/javascript" src="{{url('js/owl.min.js')}}"></script>
<script type="text/javascript" src="{{url('js/public.script.js')}}"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWQggw-OmClnyma5MoBfzCnKmA7exSqtQ&libraries=places&callback=initAutocomplete"></script>
<script type="text/javascript" src="{{url('js/google.style.js')}}"></script>    
@stop