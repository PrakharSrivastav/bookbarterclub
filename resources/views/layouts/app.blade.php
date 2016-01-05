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
        <link type="text/css" rel="stylesheet" href="{{url('css/main.css')}}"  media="screen,projection"/>
        @yield('css')
    </head>
    <body style="background: url('img/dots.png');">
        @yield('content')

        <!-- JavaScripts -->
        <script type="text/javascript" src="{{url('js/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{url('js/materialize.min.js')}}"></script>
        <script type="text/javascript" src="{{url('js/jquery.validate.min.js')}}"></script>
        @yield('javascript')
        <script>
            var base_url = "{{url('search')}}";
            var book_url = "{{url('searchBook')}}";
        </script>
        <script type="text/javascript" src="{{url('js/main.js')}}"></script>
    </body>
</html>