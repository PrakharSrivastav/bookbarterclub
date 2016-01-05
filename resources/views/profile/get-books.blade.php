@extends('layouts.profile')
@section('content')
<div class="col s12 padding-top-5 card large yellow darken-2" style="height:auto; overflow:hidden;min-height:400px">
    @if(isset($my_books) && count($my_books)>0)
    <div class="row">
        <h5>My Books</h5>
        @foreach($my_books as $book)
        @if($book->is_lendable == '1')
        <div class="col s6 m3">
            <div class="card small hoverable yellow lighten-1 ">
                <div class="card-image waves-effect waves-block waves-light yellow lighten-1 ">
                    <img class="activator" src="{{$book->image}}">
                </div>
                <div class="card-content yellow lighten-1 ">
                    <span class="card-title weight-300 activator grey-text text-darken-4">{{$book->title}}<!-- <i class="material-icons tiny right">more_vert</i> --></span>
                    <p><a href="{{route('user.delete.books',['id'=>$user->id,'book_id'=>$book->id])}}" class="red-text  btn-flat weight-300">Remove</a></p>
                </div>
                <div class="card-reveal yellow lighten-1 ">
                    <span class="card-title grey-text text-darken-4">{{$book->title}}<i class="material-icons tiny right">close</i></span>
                    <p class="weight-300">{{substr($book->desc,0,100)}}</p>
                    <p><a href="{{route('user.delete.books',['id'=>$user->id,'book_id'=>$book->id])}}" class="red-text  btn-flat weight-300">Remove</a></p>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
    <hr/>
    <div class="row">
        <h5>My wishLlist</h5>
        @foreach($my_books as $book)
        @if($book->is_wishlist == '1')
        <div class="col s6 m3">
            <div class="card small hoverable yellow lighten-1 ">
                <div class="card-image waves-effect waves-block waves-light yellow lighten-1 ">
                    <img class="activator" src="{{$book->image}}">
                </div>
                <div class="card-content yellow lighten-1 ">
                    <span class="card-title weight-300 activator grey-text text-darken-4">{{$book->title}}<!-- <i class="material-icons tiny right">more_vert</i> --></span>
                    <p><a href="{{route('user.delete.books',['id'=>$user->id,'book_id'=>$book->id])}}" class="red-text  btn-flat weight-300">Remove</a></p>
                </div>
                <div class="card-reveal yellow lighten-1 ">
                    <span class="card-title grey-text text-darken-4">{{$book->title}}<i class="material-icons tiny right">close</i></span>
                    <p class="weight-300">{{substr($book->desc,0,100)}}</p>
                    <p><a href="{{route('user.delete.books',['id'=>$user->id,'book_id'=>$book->id])}}" class="red-text  btn-flat weight-300">Remove</a></p>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
    @endif
</div>
@stop