@extends('layouts.profile')
@section('content')
<div class="col s12 grey padding-none margin-none margin-top-10 lighten-2" style="height:auto; overflow:hidden;min-height:400px">
    @if(isset($my_books) && count($my_books)>0)
    <div class="row grey lighten-2 margin-none padding-none">
        <div class="col s12 margin-none padding-none">
            <ul class="tabs padding-none margin-none" style="overflow:hidden">
                <li class="tab col s4 grey lighten-1"><a href="#mybooks" class="black-text active">User's Books</a></li>
                <li class="tab col s4 grey lighten-1"><a class="black-text" href="#wishlist">User's Wishlist</a></li>
                <li class="tab col s4 grey lighten-1"><a href="#bookstore" class="black-text">User's Bookstore</a></li>
            </ul>
        </div>
        <div id="mybooks" class="col s12">
            <div class="row">
                <h5 class=" weight-300">Books Available for lending</h5>
                @foreach($my_books as $book)
                @if($book->is_lendable == '1')
                <div class="col s6 m2">
                    <div class="card  hoverable yellow lighten-1 ">
                        <div class="card-image waves-effect waves-block waves-light yellow lighten-1 ">
                            <img class="activator weight-300" height="150px" src="{{$book->image}}">
                        </div>
                        <div class="card-content yellow lighten-1 weight-300 padding-5"><small>{{substr($book->title,0,15).' ...'}}</small></div>
                        <div class="card-reveal yellow lighten-1 padding-5">
                            <div style="position:absolute;top:5px;left:2px"><small class="card-title font-12 grey-text text-darken-4 col s10">{{substr($book->title,0,15).' ...'}}</small></div>
                            <div style="position:absolute;top:5px;right:2px"><i class="card-title mdi-hardware-keyboard-arrow-down "></i></div>
                            <hr style="margin-top:35px;color:#000;background:#000" />
                            <div class="weight-300 padding-5 font-12 col s12">{!!substr($book->desc,0,80)." ..."!!}</div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        <div id="wishlist" class="col s12">
            <div class="row">
                <h5 class=" weight-300">User's wishLlist</h5>
                @foreach($my_books as $book)
                @if($book->is_wishlist == '1')
                <div class="col s6 m2">
                    <div class="card  hoverable yellow lighten-1 ">
                        <div class="card-image waves-effect waves-block waves-light yellow lighten-1 ">
                            <img class="activator" height="150px" src="{{$book->image}}">
                        </div>
                        <div class="card-content yellow lighten-1 weight-300 padding-5"><small>{{substr($book->title,0,15).' ...'}}</small></div>
                        <div class="card-reveal yellow lighten-1 padding-5">
                            <div style="position:absolute;top:5px;left:2px"><small class="card-title font-12 grey-text text-darken-4 col s10">{{substr($book->title,0,15).' ...'}}</small></div>
                            <div style="position:absolute;top:5px;right:2px"><i class="card-title mdi-hardware-keyboard-arrow-down "></i></div>
                            <hr style="margin-top:35px;color:#000;background:#000" />
                            <div class="weight-300 padding-5 font-12 col s12">{!!substr($book->desc,0,80)." ..."!!}</div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        <div id="bookstore" class="col s12">
            <div class="row">
                <h5 class=" weight-300">User's BookStore</h5>
                <input type="hidden" id="csrf_token" value="{{csrf_token()}}">
                @foreach($my_books as $book)
                @if($book->is_sellable == '1')
                <div class="col s6 m2">
                    <div class="card  hoverable yellow lighten-1 ">
                        <div class="card-image waves-effect waves-block waves-light yellow lighten-1 ">
                            <img class="activator" height="150px" src="{{$book->image}}">
                            @if($book->image == "https://s.gr-assets.com/assets/nophoto/book/111x148-bcc042a9c91a29c1d680899eff700a03.png")
                            <span style="position:absolute;top:5px;right:5px" class="black-text card-title padding-5 weight-400">{{substr($book->title,0,15).' ...'}}</span>
                            @endif
                            <input type="hidden" id="price_{{$book->book_id}}" value="{{$book->selling_price}}">
                            <input type="hidden" id="id_{{$book->book_id}}" value="{{$book->id}}">
                        </div>
                        <div class="card-content yellow lighten-1 weight-300 padding-5"><small>{{substr($book->title,0,15).' ...'}}</small></div>
                        <div class="card-reveal yellow lighten-1 padding-5">
                            <div style="position:absolute;top:5px;left:2px"><small class="card-title font-12 grey-text text-darken-4 col s10">{{substr($book->title,0,15).' ...'}}</small></div>
                            <div style="position:absolute;top:5px;right:2px"><i class="card-title mdi-hardware-keyboard-arrow-down "></i></div>
                            <hr style="margin-top:35px;color:#000;background:#000" />
                            <div class="weight-300 padding-5 font-12 col s12">{!!substr($book->desc,0,80)." ..."!!}</div>
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