<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <meta name="csrf-token" content=""> -->
        <title>{{ isset($title)?$title: "Book Barter Club"}}</title>
        <!-- Fonts -->
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="{{url('css/materialize.min.css')}}"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="{{url('css/main.css')}}"  media="screen,projection"/>
        @yield('css')
    </head><!-- style="background: url('img/dots.png');" -->
    <body class="grey lighten-5">
        @yield('content')

        <!-- JavaScripts -->
        <script type="text/javascript" src="{{url('js/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{url('js/materialize.min.js')}}"></script>
        <script type="text/javascript" src="{{url('js/jquery.validate.min.js')}}"></script>
        @yield('javascript')
        <script>
            var base_url = "{{url('search')}}";
            var book_url = "{{route('book.details')}}";
            var nearest_user = "{{route('book.nearest.user',['book_id'=>'__book_id__'])}}";
        </script>
    </body>
</html>