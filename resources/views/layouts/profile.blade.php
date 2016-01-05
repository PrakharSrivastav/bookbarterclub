<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ isset($title)?$title: "Book Barter Club"}}</title>
        <!-- Fonts -->
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="{{url('css/materialize.min.css')}}"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="{{url('css/owl.css')}}"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="{{url('css/main.css')}}"  media="screen,projection"/>
        @yield('css')
    </head>
    <body class="deep-orange lighten-5">
        <ul id="dropdown1"  class="dropdown-content">
            <li><a href="{{route('user.edit',[$user->id])}}" class="black-text">Edit Profile</a></li>
            <li class="divider"></li>
            <li><a href="{{url('/logout')}}" class="red-text">Logout</a></li>
        </ul>
        <nav class="yellow darken-2">
            <div class="nav-wrapper margin-left-5">
                <a href="{{route('dashboard')}}" class="brand-logo weight-300 black-text">Book Barter Club</a>
                <a href="#" data-activates="mobile-view" class="button-collapse"><i class="material-icons black-text">menu</i></a>
                <ul class="right hide-on-med-and-down">
                    <!-- <li><input id="search" type="search" required></li> -->
                    <li><a href="{{route('user.get.books',[$user->id])}}" class="black-text">My Books</a></li>
                    <li><a href="sass.html" class="black-text">My Stories</a></li>
                    <li><a href="sass.html" class="black-text">Messages</a></li>
                    <li><a href="badges.html" class="black-text">Notifications</a></li>
                    <li>
                        <a class="dropdown-button black-text" href="#!" data-beloworigin="true" data-activates="dropdown1">Profile <i class="material-icons right">arrow_drop_down</i></a>
                    </li>
                </ul>
                <ul class="side-nav yellow darken-2" id="mobile-view">
                    <li><a href="{{route('user.get.books',[$user->id])}}">My Books</a></li>
                    <li><a href="badges.html">My Stories</a></li>
                    <li><a href="collapsible.html">Messages</a></li>
                    <li><a href="mobile.html">Notifications</a></li>
                    <li><a href="{{route('user.edit',[$user->id])}}">Edit Profile</a></li>
                    <li><a href="{{url('/logout')}}" class="red-text text-darken-2">Logout</a></li>
                </ul>
            </div>
        </nav>
        <div class="row">
            <div class="col s12 m8">
                @yield('content')
            </div>
            <div class="col s12 m4 padding-none">
                <div class="col s12">
                    <ul class="collapsible " data-collapsible="accordion">
                        <li>
                            <div class="collapsible-header yellow darken-2 "><i class="material-icons">search</i>Search Books Near You</div>
                            <div class="collapsible-body white">
                                <div class="input-field margin-top--5 white padding-none">
                                    <input id="search" type="search" class="search border-none" placeholder="Your book title">
                                </div>
                                <div id="result" class="results collection border-none">
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col s12 " >
                    <div class="hoverable yellow darken-2 padding-10">
                        @if(count($books) > 0)
                        <h3 class="weight-200 center-align">Trending Books</h3>
                        <div id="owl-demo-sidebar" style="padding:10px 8px 0px 15px">
                            @foreach($books as $book)
                            <div class="item col s12 l12" style="margin-left:-8px">
                                <div class="card hoverable orange lighten-2">
                                    <div class="card-image">
                                        <img class="activator" width="auto" height="180px" src="{{$book->image}}">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" value="{{csrf_token()}}" id="this_token">
        <div id="modal1" class="modal bottom-sheet">
        </div>
        <!-- JavaScripts -->
        <script type="text/javascript" src="{{url('js/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{url('js/materialize.min.js')}}"></script>
        @yield('javascript')
        <script type="text/javascript" src="{{url('js/jquery.validate.min.js')}}"></script>
        <script type="text/javascript" src="{{url('js/owl.min.js')}}"></script>
        <script>
        var base_url = "{{url('search')}}";
        var base = "{{url('/')}}";
        var book_url = "{{url('searchBook')}}";
        var add_book = "{{route('user.create.books',$user->id)}}";
        var show_user = "{{route('user.show.books',['id'=>'__user__id__','book_id'=>'__book__id__'])}}";
        </script>
        <script type="text/javascript" src="{{url('js/main.js')}}"></script>
    </body>
</html>