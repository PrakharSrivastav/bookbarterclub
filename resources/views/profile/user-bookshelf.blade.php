@extends('layouts.profile')
@section('content')
<div class="col s12 grey padding-none margin-none margin-top-10 lighten-2" style="height:auto; overflow:hidden;min-height:400px">
    @if(isset($my_books) && count($my_books)>0)
    <div class="row grey lighten-2 margin-none padding-none">
        <div class="col s12 margin-none padding-none">
            <ul class="tabs padding-none margin-none" style="overflow:hidden">
                <li class="tab col s4 red darken-2"><a href="#mybooks" class="grey-text text-lighten-4 active">{{$new_user->name}}'s Books</a></li>
                <li class="tab col s4 red darken-2"><a class="grey-text text-lighten-4" href="#wishlist">{{$new_user->name}}'s Wishlist</a></li>
                <li class="tab col s4 red darken-2"><a href="#bookstore" class="grey-text text-lighten-4">{{$new_user->name}}'s Bookstore</a></li>
            </ul>
        </div>
        <div id="mybooks" class="col s12 white">
            <div class="row">
                <h5 class=" weight-300">Books Available for lending</h5>
                @foreach($my_books as $book)
                @if($book->is_lendable == '1')
                <div class="col s6 m2">
                    <div class="card  hoverable red darken-2 ">
                        <div class="card-image waves-effect waves-block waves-light red darken-2 ">
                            <img class="activator weight-300" height="150px" src="{{$book->image}}">
                        </div>
                        <div class="card-content red darken-2 grey-text text-lighten-4 weight-300 padding-5"><small>{{substr($book->title,0,10).' ..'}}</small></div>
                        <div class="card-reveal row padding-none">
                            <div class="col s12 red darken-2 padding-5">
                                <small class="card-title left font-12 grey-text text-lighten-4">{{substr($book->title,0,10).'..'}}</small>
                                <i class="card-title grey-text text-lighten-4 mdi-hardware-keyboard-arrow-down right"></i>
                            </div>
                            <div class="font-13 col padding-5 white black-text s12">{!!substr($book->desc,0,80)." ..."!!}</div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        <div id="wishlist" class="col s12 white">
            <div class="row">
                <h5 class=" weight-300">User's wishLlist</h5>
                @foreach($my_books as $book)
                @if($book->is_wishlist == '1')
                <div class="col s6 m2">
                    <div class="card  hoverable red darken-2 ">
                        <div class="card-image waves-effect waves-block waves-light red darken-2 ">
                            <img class="activator" height="150px" src="{{$book->image}}">
                        </div>
                        <div class="card-content red darken-2 grey-text text-lighten-4 weight-300 padding-5"><small>{{substr($book->title,0,15).' ...'}}</small></div>
                        <div class="card-reveal row padding-none">
                            <div class="col s12 red darken-2 padding-5">
                                <small class="card-title left font-12 grey-text text-lighten-4">{{substr($book->title,0,10).'..'}}</small>
                                <i class="card-title grey-text text-lighten-4 mdi-hardware-keyboard-arrow-down right"></i>
                            </div>
                            <div class="font-13 col padding-5 white black-text s12">{!!substr($book->desc,0,80)." ..."!!}</div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        <div id="bookstore" class="col s12 white">
            <div class="row">
                <h5 class=" weight-300">User's BookStore</h5>
                <input type="hidden" id="csrf_token" value="{{csrf_token()}}">
                @foreach($my_books as $book)
                @if($book->is_sellable == '1')
                <div class="col s6 m2">
                    <div class="card  hoverable red darken-2 ">
                        <div class="card-image waves-effect waves-block waves-light red darken-2 ">
                            <img class="activator" height="150px" src="{{$book->image}}">
                            @if($book->image == "https://s.gr-assets.com/assets/nophoto/book/111x148-bcc042a9c91a29c1d680899eff700a03.png")
                            <span style="position:absolute;top:5px;right:5px" class="black-text card-title padding-5 weight-400">{{substr($book->title,0,15).' ...'}}</span>
                            @endif
                            <input type="hidden" id="price_{{$book->book_id}}" value="{{$book->selling_price}}">
                            <input type="hidden" id="id_{{$book->book_id}}" value="{{$book->id}}">
                        </div>
                        <div class="card-content red darken-2 grey-text text-lighten-4 weight-300 padding-5"><small>{{substr($book->title,0,15).' ...'}}</small></div>
                        <div class="card-reveal row padding-none">
                            <div class="col s12 red darken-2 padding-5">
                                <small class="card-title left font-12 grey-text text-lighten-4">{{substr($book->title,0,10).'..'}}</small>
                                <i class="card-title grey-text text-lighten-4 mdi-hardware-keyboard-arrow-down right"></i>
                            </div>
                            <div class="font-13 col padding-5 white black-text s12">{!!substr($book->desc,0,80)." ..."!!}</div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
    @else
    <h5 class="weight-300">The user does not have any books in the bookshelf.</h5>
    @endif
</div>
@stop