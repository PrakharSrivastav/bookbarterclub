<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <title>
            {{ isset($title)?$title: "Book Barter Club"}}
        </title>
        <!-- Fonts -->
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
        <link type="text/css" rel="stylesheet" href="{{url('css/materialize.min.css')}}"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="{{url('css/owl.css')}}"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="{{url('css/main.css')}}"  media="screen,projection"/>
        @yield('css')
    </head>
    <body class="white">
        <ul id="dropdown1"  class="dropdown-content">
            <li>
                <a href="{{route('dashboard')}}" class="black-text">
                    Edit Location
                </a>
            </li>
            <li>
                <a href="{{route('user.edit.profile')}}" class="black-text">
                    Edit Profile
                </a>
            </li>
            <li class="divider">
            </li>
            <li>
                <a href="{{url('/logout')}}" class="red-text">
                    Logout
                </a>
            </li>
        </ul>
        <nav class="white">
            <div class="nav-wrapper margin-left-5">
                <div class="left">
                    <a href="{{route('dashboard')}}" class="brand-logo weight-300 black-text">
                        Book Barter Club
                    </a>
                </div>
                <a href="#" data-activates="mobile-view" class="button-collapse">
                    <i class="material-icons black-text">
                        menu
                    </i>
                </a>
                <ul class="right hide-on-med-and-down">
                    <li class="margin-right-10">
                        <span class="red-text margin-right-10">
                            Welcome {{$user->email}}
                        </span>
                    </li>
                    <li>
                        <a href="{{route('user.getuser.books')}}" class="black-text">
                            My Books
                        </a>
                    </li>
                    <li>
                        <a href="{{route('all_messages')}}" class="black-text">
                        Messages
                        @if($user->notif == '1')
                        <span class="red font-12 padding-2 yellow-text" style="border-radius:2px">new</span>
                        @endif
                        </a>
                    </li>
                    <li style="width:150px !important">
                        <a class="dropdown-button black-text" href="#!" data-beloworigin="true" data-activates="dropdown1">
                            Profile
                            <i class="material-icons right">
                                arrow_drop_down
                            </i>
                        </a>
                    </li>
                </ul>
                <ul class="side-nav white" id="mobile-view">
                    <li class="margin-right-10">
                        <span class="red-text">
                            Welcome {{$user->email}}
                        </span>
                    </li>
                    <li>
                        <a href="{{route('user.getuser.books')}}">
                            My Books
                        </a>
                    </li>
                    <li>
                        <a href="{{route('all_messages')}}">
                            Messages
                            @if($user->notif == '1')
                        <span class="red font-12 padding-2 yellow-text" style="border-radius:2px">new</span>
                        @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{route('dashboard')}}" class="black-text">
                            Edit Location
                        </a>
                    </li>
                    <li>
                        <a href="{{route('user.edit.profile')}}">
                            Edit Profile
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/logout')}}" class="red-text text-darken-2">
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <div id="preloader">
        </div>
        <div class="row margin-none">
            <div class="col s12 m8 margin-none">
                @yield('content')
            </div>
            <div class="col s12 m4 padding-none margin-none">
                <div class="col s12 padding-none padding-right-5">
                    <ul class="collapsible z-depth-0" data-collapsible="accordion">
                        <li>
                            <div class="collapsible-header grey lighten-2 active">
                                <i class="material-icons">
                                    search
                                </i>
                                Search Books Near You
                            </div>
                            <div class="collapsible-body grey lighten-2">
                                <div class="input-field margin-top--5 grey lighten-2 padding-none border-top-grey">
                                    <input id="search" type="search" class="search border-top-grey" placeholder="Your book title"/>
                                </div>
                                <div id="result" class="results collection border-none">
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col s12 padding-none margin-none margin-top--5 padding-right-5" >
                    <div class="hoverable grey lighten-2 padding-10">
                        @if(count($books) > 0)
                        <h6 class="weight-300 center-align">
                            Trending Books
                        </h6>
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
        <input type="hidden" value="{{csrf_token()}}" id="this_token"/>
        <div id="modal1" class="modal ">
        </div>
        <!-- JavaScripts -->
        <script type="text/javascript" src="{{url('js/jquery.min.js')}}">
        </script>
        <script type="text/javascript" src="{{url('js/materialize.min.js')}}">
        </script>
        @yield('javascript')
        <script type="text/javascript" src="{{url('js/jquery.validate.min.js')}}">
        </script>
        <script type="text/javascript" src="{{url('js/owl.min.js')}}">
        </script>
        <script>
            var location_mine = "{{$user->location_name}}";
            var base_url = "{{url('search')}}";
            var base = "{{url('/')}}";
            var book_url = "{{url('searchBook')}}";
            // var add_book = "route('user.create.books',$user->id)";
            var show_user = "{{route('user.show.books',['book_id'=>'__book__id__'])}}";
        </script>
        <script type="text/javascript" src="{{url('js/main.js')}}">
        </script>
    </body>
</html>
