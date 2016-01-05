@extends("layouts.app")
@section('css')
<link type="text/css" rel="stylesheet" href="{{url('css/owl.css')}}"  media="screen,projection"/>
<link type="text/css" rel="stylesheet" href="{{url('css/google.style.css')}}"  media="screen,projection"/>
@stop
@section("content")
<div class="row padding-none margin-none">
    <div class="col s12 m6 yellow darken-2 margin-none padding-none">
        <nav class="col s12 yellow darken-2 padding-none">
            <span class="title padding-none">Book Barter Club <small class="hide-on-small-only wieght-200" style='font-size:20px;padding-left:10px'>Let your books relive....</small></span>
        </nav>
        <div class="row margin-none">
            <div class="col s12 white padding-none margin-top-5">
                <nav class='white'>
                    <div class="nav-wrapper center">
                        <div class="col s12">
                            <a href="{{url('/login')}}" class="btn-flat">[ Login ]</a>
                            <a href="{{url('/register')}}" class="btn-flat">[ Register ]</a>
                            <a href="#!" class="btn-flat">[ Read User Stories ]</a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="padding-25" >
            <p class="flow-text center-align weight-200">
            <!-- Book Barter Club is an online community of book lovers who believe that books should be shared freely.<br/> -->
            Book Barter Club is an attempt to bring back to life all the books that have been gathering dust on the bookshelf or have been packed in a carton box, or have been stocked in the garage never to be read by anyone.
            </p>
            @if(count($books) > 0)
            <h3 class="weight-200 center-align">Trending Books</h3>
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
    <div class="col s12 m6">
        <ul class="collapsible" data-collapsible="accordion">
            <li>
                <div class="collapsible-header yellow darken-2 margin-top-5"><i class="material-icons">info_outline</i>About Us </div>
                <div class="collapsible-body white weight-300">
                    <div  style="height:400px;overflow-y:auto;padding:30px">
                        Book Barter Club is an online community of book lovers who believe that books should be shared freely. Through book barter club you can Borrow, Lend or Exchange any book with other book lovers around you. In the process you get to meet like-minded people and expand your network of friends.
                        <br/><br/>
                        Book Barter Club is an attempt to bring back to life all the books that have been gathering dust on the bookshelf or have been packed in a carton box, or have been stocked in the garage never to be read by anyone.
                        Book Barter Club is an attempt to build a community of learned people who believe that knowledge is power and that sharing is caring. That a single copy of a book can be read by a million readers and yet there will be one more person to borrow it and one more to lend it.
                        For the love of books and for the love of free sharing of knowledge, BBC is an attempt to bring out all books into circulation so that there is a library in every neighbourhood.
                        <br/><br/>
                        Create your own BBC library online and let books be exchanged freely.
                        In your attempt to exchange books, you will get a chance to meet new and like-minded people helping you build your circle of friends beyond FB and other social sites. Through BBC we hope we will be able to break free from the clutches of being hooked on to our laptops and phones and meet real people and share real stories.
                        After all that’s what books do….help to share some stories.
                        Share a book, meet new people, share some stories…
                        <!-- </p> -->
                        <!-- <h4 class="weight-200">How to get stared</h4> -->
                        <!-- <p> -->
                        <ul class="weight-300" >
                            <li>Create your account</li>
                            <li>Set your location</li>
                            <li>Add the books that you have and would like to lend/exchange</li>
                            <li>Search for books you want or books available for borrowing near you</li>
                            <li>Connect with the owner the book by sending them a quick message</li>
                            <li>Set up a meeting at an acceptable date, place and time</li>
                            <li>Meet to exchange/lend/borrow the book - enjoy your new book</li>
                        </ul>
                    </div>
                </div>
            </li>
            <li>
                <div class="collapsible-header yellow darken-2 active margin-top-5"><i class="material-icons">place</i>Your Location</div>
                <div class="collapsible-body">
                    <input id="pac-input" class="controls" type="text" placeholder="Search Box" style="margin-top:5px">
                    <div  id="map" style="height:400px"></div>
                </div>
            </li>
            <li>
                <div class="collapsible-header yellow darken-2 margin-top-5"><i class="material-icons">book</i>Search your books</div>
                <div class="collapsible-body white">
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
                <div class="collapsible-header yellow darken-2 margin-top-5"><i class="material-icons">message</i>Contact Us</div>
                <div class="collapsible-body white padding-15">
                    <!-- <span class="card-title ">Suggestions</span> -->
                    <form class="row padding-none">
                        <div class="input-field col s12 padding-none">
                            <input id="first_name" type="text" class="validate padding-none">
                            <label for="first_name">Name</label>
                        </div>
                        <div class="input-field col s12 padding-none">
                            <input id="email" type="email" class="validate padding-none">
                            <label for="email">Email</label>
                        </div>
                        <div class="input-field col s12 padding-none">
                            <textarea id="textarea1" rows='5' class="materialize-textarea padding-none"></textarea>
                            <label for="textarea1">Your Message</label>
                        </div>
                        <input type="submit" class="waves-effect waves-light btn btn-large  btn-block  brown-text text-darken-4 yellow darken-2" value="Send">
                    </form>
                </div>
            </li>
        </ul>
    </div>
</div>
<footer class="page-footer padding-none margin-none white yellow-text">
    <div class="footer-copyright">
        <div class="container brown-text text-darken-4">
            © 2016 : Book Barter Club
            <a class="margin-top-5 padding-5 right"  href="#!"><img alt="social media" src="img/facebook.svg"></a>
            <a class="margin-top-5 padding-5 right"  href="#!"><img alt="social media" src="img/google.svg"></a>
            <a class="margin-top-5 padding-5 right"  href="#!"><img alt="social media" src="img/twitter.svg"></a>
        </div>
    </div>
</footer>
@stop
@section('javascript')
<script type="text/javascript" src="{{url('js/owl.min.js')}}"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWQggw-OmClnyma5MoBfzCnKmA7exSqtQ&libraries=places&callback=initAutocomplete"></script>
<script type="text/javascript" src="{{url('js/google.style.js')}}"></script>
@stop