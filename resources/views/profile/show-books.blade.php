@extends('layouts.profile')
@section('content')
<div class="col s12 padding-top-5 margin-none margin-top-5 grey lighten-2" style="height:auto;">
    <div class="row">
        <h5 class="weight-300 padding-left-10">{{$the_book['title']}}</h5>
        <div class="col s12 m2"><br>
            <img class="img-responsive full-width"  src="{{$the_book['image']}}" >
        </div>
        <div class="col s12 m10 weight-300 padding-top-20">
            <div class="row padding-top-15">
                <div class="col s12 m6">
                    <input type="hidden" id="book_id" value="{{$the_book['book_id']}}">
                    <input type="hidden" id="csrf_token" value="{{csrf_token()}}">
                    <input type="hidden" id="title" value="{{$the_book['title']}}">
                    <input type="hidden" id="description" value="{{$the_book['description']}}">
                    <input type="hidden" id="reviews" value="{{$the_book['text_reviews_count']}}">
                    <input type="hidden" id="rating" value="{{$the_book['average_rating']}}">
                    <input type="hidden" id="image" value="{{$the_book['image']}}">
                    <input type="hidden" id="publisher" value="{{$the_book['publisher']}}">
                    <input type="hidden" id="author_name" value="{{$the_book['author_name']}}">
                    <input type="hidden" id="author_id" value="{{$the_book['author_id']}}">
                    <input type="hidden" id="source" value="{{$the_book['source']}}">
                    <input type="hidden" id="subtitle" value="{{$the_book['subtitle']}}">
                    <input type="hidden" id="isbn" value="{{$the_book['isbn']}}">
                    <input type="hidden" id="reviews_widget" value="{{$the_book['reviews_widget']}}">
                    @if(isset( $the_book['is_sellable'] ) && $the_book['is_sellable'] == '1')
                    <input type="hidden" id="is_sellable" value="1">
                    @else
                    <input type="hidden" id="is_sellable" value="0">
                    @endif
                    <div>Rating :  {{ $the_book['average_rating']}}</div>
                    <div>Review Counts :  {{ $the_book['text_reviews_count']}}</div>
                    <div>Publisher :  {{ $the_book['publisher'] }}</div>
                    @if(isset($the_book['subtitle']))
                    <div>Subtitle :  {{ $the_book['subtitle']}}</div>
                    @endif
                    <div>ISBN/ISBN13 :  {{ $the_book['isbn']}}</div>
                </div>
                <div class="col s12 m6 ">
                    <a href="" id="addToWishlist" class="btn btn-block green black-text margin-top-5">Add To Wishlist</a>
                    <a href="" id="addToBookshelf" class="btn btn-block blue black-text margin-top-5">Add to Bookshelf</a>
                    <a href="" class="btn btn-block red darken-4 black-text margin-top-5">Buy It</a>
                    <a id="sell_the_book" class="btn btn-block yellow black-text margin-top-5" href="#modal-sell">Sell It</a>
                </div>
                <!-- Modal Structure -->
                <div id="modal-sell" class="modal">
                    <div class="row modal-content">
                        <div class="row">
                            <h5 class="weight-300 left">Please provide your price <small class="grey-text text-lighten-1">&nbsp;&nbsp;&nbsp;(upto 2 decimal places. eg 50.00)</small></h5>
                            <a href="#!" class="right modal-action modal-close btn-flat margin-right-10"><i class="material-icons">close</i></a>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col s12 m8 push-m2">
                                <div class="input-field col s8">
                                    <input placeholder="Your price" id="selling_price" name="selling_price" type="number" step="0.01" min="0" class="validate">
                                    <label for="selling_price">Your Selling Price</label>
                                    <span id="error_price" class="red-text"></span>
                                </div>
                                <div class="input-field col s4">
                                    <a id="selling_btn" class="margin-top--5 btn yellow black-text z-depth-0 btn-block btn-large">Save</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
    </div>
    <div class="row margin-none padding-10">
        @if(strlen($the_book['description'])>250)
        <span class="teaser weight-300">Description : {!! substr($the_book['description'],0,250) !!}</span>
        <span class="complete  weight-300">Description : {!! $the_book['description'] !!}</span>
        <a href="" class="more blue-text text-darken-2 weight-400"><br>Show More...</a>
        @else
        <p>{!! $the_book['description'] !!}</p>
        @endif
    </div>
    <div class="row margin-none padding-10">
        <a href="" id="show_review_component" class="margin-top--5 btn amber black-text">Show Reviews</a>
        <div id="review_component">{!! $the_book['reviews_widget'] !!}</div>
    </div>
</div>
<div class="col s12  margin-none margin-top-5 padding-top-5 grey lighten-2" style="height:auto;">
    <div class="row margin-none">
        @if(isset($other_users) && count($other_users) > 0)
        <h5 class="weight-300">Users having this book.</h5>
        @foreach ($other_users as $other)
        <div class="row card amber accent-4 padding-5">
            <div class="col s12 m2 margin-none" >
                <div align="center">
                    @if(isset($other->image))
                    <img class="img-responsive hoverable margin-top-10 border-grey" width="200px" height="200px"  src="{{$other->image}}" >
                    @else
                    <img class="img-responsive hoverable margin-top-10 border-grey"  src="{{url('img/Man-14.svg')}}" >
                    @endif
                </div>  
            </div>
            <div class="col s12 m7 weight-300 padding-left-10">
                @if($other->is_sellable)
                    <div class="padding-left-10 margin-top-5 weight-500 center-align red-text white">The user is selling this book at a special price of {{$other->selling_price}}</div>
                @endif
                <div class="padding-left-10"><strong>First Name : </strong><span> {{ucwords($other->firstname)}}</span></div>
                <div class="padding-left-10"><strong>Last Name : </strong><span> {{ucwords($other->lastname)}}</span></div>
                <div class="padding-left-10"><strong>Location : </strong><span> {{ucwords($other->location_name)}}</span></div>
                @if($other->privacy == 1)
                <div class="padding-left-10"><strong>Email Address : </strong><span> {{ucwords($other->email)}}</span></div>
                <!-- <div class="padding-left-10"><strong>Gender : </strong><span> {{ucwords($other->gender == '0' ? 'Unknown':($other->gender=='1')?'Male':'Female')}}</span></div> -->
                <!-- <div class="padding-left-10"><strong>Date of Birth : </strong><span> {{ucwords($other->dob)}}</span></div> -->
                @endif
            </div>
            <div class="col m3 s12 " >
                <a href="" id="{{ $other->id }}" class="btn borrow btn-block grey lighten-2 black-text margin-top-5">Borrow</a>
                <a href="{{route('user.show.bookshelf',['id'=>$other->id])}}"  class="btn btn-block grey lighten-2 black-text margin-top-5">bookshelf</a>
                @if($other->is_sellable)
                    <a href="" id="" class="btn btn-block grey lighten-2 black-text margin-top-5">Buy It</a>
                @endif
            </div>
        </div>
        @endforeach
        @endif
        <!-- Modal for Sending request structure -->
        <div id="modal-borrow" class="modal">
            <div class="row modal-content">
                <div class="row margin-none">
                    <h5 class="weight-300 left">Please send a quick message to the Owner </h5>
                    <a href="#!" class="right modal-action modal-close btn-flat margin-right-10"><i class="material-icons">close</i></a>
                </div>
                <br>
                <div class="row margin-none padding-none">
                    <div class="col s12 m8 margin-none padding-none push-m2">
                        <div class="input-field col s12">
                            <textarea id="message" class="materialize-textarea"></textarea>
                            <label for="message">Your Message</label>
                            <span id="error_message" class="red-text"></span>
                        </div>
                        <div class="input-field col s12">
                            <a id="borrow_btn" class="margin-top--5 btn yellow black-text z-depth-0 btn-block btn-large">Send Message</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(isset($suggestions))
        <div class="row ">
            @if(count($other_users) > 0)
            <h5 class="center-align weight-300">More books near your area</h5>
            @else
            <h5 class="center-align weight-300">Sorry, we could not find any matches for this book. Here are some more book near your area.</h5>
            @endif
            @foreach($suggestions as $abook)
            <div class="col s6 m4 l3 margin-top-5 padding-10">
                <div class="card hoverable yellow small padding-none margin-none">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="{{$abook['image']}}">
                    </div>
                    <div class="card-content">
                        <span class="card-title weight-400 activator grey-text text-darken-4"><i class="mdi-navigation-more-vert right"></i>{{ substr($abook['title'],0,15)." ..."}}</span>
                        <div class="weight-300 margin-top-5">Distance : {{$abook['distance']}}</div>
                        <a class="btn white black-text" href="{{route('user.show.books',['book_id'=>$abook['id']])}}" style="position:absolute;bottom:5px;left:5px">&nbsp;&nbsp;View Details&nbsp;&nbsp;</a>
                        <div style="clear:both"></div>
                    </div>
                    <div class="card-reveal yellow paddig-5" style="overflow-x:hidden">
                        <span class="card-title grey-text text-darken-4"><i class="mdi-hardware-keyboard-arrow-down right"></i>{{$abook['title']}}</span>
                        <hr/>
                        <p class="weight-300">{!! substr($abook['desc'],0,100)."..." !!}</p>
                        <div class="weight-300 margin-top-5">Rating : {{$abook['rating']}}</div>
                        <a class="btn white black-text" href="{{route('user.show.books',['book_id'=>$abook['id']])}}" style="position:absolute;bottom:5px;left:5px">&nbsp;&nbsp;View Details&nbsp;&nbsp;</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@stop
@section('javascript')
<script>
addToWishList = "{{route('user.add.wishlist')}}";
addToBookshelf = "{{route('user.add.bookshelf')}}";
addToBookstore = "{{route('user.add.bookstore')}}";
sendMessage = "{{route('create.message')}}";
var messge_target_user = "";
var borrow_message = {
    _token : $("#csrf_token").val()
}
$(".borrow").click(function(e){
    e.preventDefault();
    messge_target_user = $(this).attr("id"); 
    $("#modal-borrow").openModal();
});
$("#borrow_btn").click(function(e){
    e.preventDefault();
    borrow_message.user = messge_target_user;
    borrow_message.data = $("textarea#message").val();
    console.log(borrow_message);
    $.ajax({
        url: sendMessage,
        type: 'POST',
        dataType: 'json',
        data: borrow_message,
    })
    .done(function(a) {
        Materialize.toast(a.message , 5000);
        return false;
    })
    .fail(function(b) {
        Materialize.toast("You are not allowed to make this operation" , 5000);
        return false;
    })
    .always(function(c) {
        $("#modal-borrow").closeModal();
    });
});

$(".complete").hide();
$(".more").click(function(e) {
    e.preventDefault();
    el = $(this);
    if (el.hasClass('text-darken-2')) {
        el.removeClass('text-darken-2');
        el.addClass('text-darken-3');
        $(this).html("<br>Show Less ....");
    } else {
        el.removeClass('text-darken-3');
        el.addClass('text-darken-2');
        $(this).html("<br>Show More ....");
    }
    $(".teaser").toggle();
    $(".complete").slideToggle(400);
})
$("#review_component").hide();
$("#show_review_component").click(function(e) {
    e.preventDefault();
    $("#review_component").slideToggle(400);
})
var post_data = {
        book_id : $("#book_id").val(),
        _token : $("#csrf_token").val(),
        title : $("#title").val(),
        description : $("#description").val(),
        reviews : $("#reviews").val(),
        rating : $("#rating").val(),
        image : $("#image").val(),
        publisher : $("#publisher").val(),
        author_name : $("#author_name").val(),
        author_id : $("#author_id").val(),
        source : $("#source").val(),
        subtitle : $("#subtitle").val(),
        isbn : $("#isbn").val(),
        reviews_widget : $("#reviews_widget").val(),
    }
currentRequest = null;
$("#addToWishlist").click(function(e) {
    e.preventDefault();
    currentRequest = jQuery.ajax({
        url: addToWishList,
        method : "POST",
        dataType: "json",
        scriptCharset: "UTF-8",
        data : post_data,
        beforeSend: function() {
            if (currentRequest != null) {
                currentRequest.abort();
            }
        },
        success: function(a, b, c) {
            if(a.code == 100 ){
                Materialize.toast(a.message , 5000);
                return false;
            }
            else if(a.code == 101 ){
                Materialize.toast(a.message , 5000);
                return false;
            }
        },
        error: function(a, b, c) {
            console.log(a);
            console.log(b);
            console.log(c);
            Materialize.toast("You are not allowed to make that operation" , 5000);
            return false;
        }
    });
});
$("#addToBookshelf").click(function(e) {
    e.preventDefault();
    currentRequest = jQuery.ajax({
        url: addToBookshelf,
        method : "POST",
        dataType: "json",
        scriptCharset: "UTF-8",
        data : post_data,
        beforeSend: function() {
            if (currentRequest != null) {
                currentRequest.abort();
            }
        },
        success: function(a, b, c) {
            if(a.code == 100 ){
                Materialize.toast(a.message , 5000);
                return false;
            }
            else if(a.code == 101 ){
                Materialize.toast(a.message , 5000);
                return false;
            }
        },
        error: function(a, b, c) {
            console.log(a);
            console.log(b);
            console.log(c);
            Materialize.toast("You are not allowed to make that operation" , 5000);
            return false;
        }
    });
});
$("#sell_the_book").click(function(e){
    e.preventDefault();
    sellable = $("#is_sellable").val();
    if(sellable == "1"){
        Materialize.toast("This book is already in your book store.<br>To edit the price go to 'My Books' and edit the book in your book store" , 5000);
        return false;
    }
    else{
        $('#modal-sell').openModal();
    }
    
});
$("#selling_price").keyup(function(){
    if(this.checkValidity()){
        $("#error_price").text("");
    }
    else
        $("#error_price").text("Please check the price format");
});
$("#selling_btn").click(function(e){
    e.preventDefault();
    sp = $("#selling_price").val();
    // if the price is fine
    if(!/^\s*$/.test(sp) && !isNaN(sp)){
        $("#error_price").text("");
        post_data.selling_price = $("#selling_price").val();
        jQuery.ajax({
            url: addToBookstore,
            method : "POST",
            dataType: "json",
            scriptCharset: "UTF-8",
            data : post_data,
            beforeSend: function() {
            },
            success: function(a, b, c) {
                if(a.code == 100 ){
                    Materialize.toast(a.message , 5000);
                    $('#modal-sell').closeModal();
                    return false;
                }
                else if(a.code == 101 ){
                    Materialize.toast(a.message , 5000);
                    $('#modal-sell').closeModal();
                    return false;
                }
            },
            error: function(a, b, c) {
                console.log(a);
                console.log(b);
                console.log(c);
                $('#modal-sell').closeModal()
                Materialize.toast("You are not allowed to make that operation" , 5000);
                return false;
            }
        });
    }
    else{
        $("#error_price").text("Please check the price format");
        return false;
    }
    
});
</script>
@stop