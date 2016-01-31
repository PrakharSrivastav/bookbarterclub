@extends('layouts.profile')
@section('content')
<div class="col s12 padding-none margin-none margin-top-10" style="height:auto; overflow:hidden;min-height:400px">
    @if(isset($my_books) && count($my_books)>0)
    <div class="row white margin-none padding-none">
        <div class="col s12 margin-none padding-none">
            <ul class="tabs padding-none margin-none" style="overflow:hidden">
                <li class="tab col s4 red darken-2"><a href="#mybooks" class="grey-text text-lighten-4 active">My Books</a></li>
                <li class="tab col s4 red darken-2"><a class="grey-text text-lighten-4"href="#wishlist">My Wishlist</a></li>
                <li class="tab col s4 red darken-2"><a href="#bookstore" class="grey-text text-lighten-4">My Bookstore</a></li>
            </ul>
        </div>
        <div id="mybooks" class="col s12">
            <div class="row">
                <h5 class=" weight-300">My Books Available for lending</h5>
                @foreach($my_books as $book)
                @if($book->is_lendable == '1')
                <div class="col s6 m4 l2">
                    <div class="card  hoverable ">
                        <div class="card-image">
                            <img class="activator weight-300" height="150px" src="{{$book->image}}">
                        </div>
                        <div class="card-content red darken-2 ">
                            <a style="position:absolute;bottom:5px;left:5px" href="{{route('user.delete.books',['id'=>$user->id,'book_id'=>$book->id,'book_type'=>'lendable'])}}" class="grey-text text-lighten-4 btn-flat weight-400">Remove</a>
                        </div>
                        <div class="card-reveal padding-none margin-none">
                            <div class="red darken-2 padding-2">
                            <small class="card-title left font-13 grey-text text-lighten-4">{{substr($book->title,0,11).' ..'}}</small>
                            <i class="card-title grey-text text-lighten-4 mdi-hardware-keyboard-arrow-down right "></i>
                            <div style="clear:both"></div>
                            </div>
                            <div class="weight-300 padding-5 font-12 col s12">{{substr($book->desc,0,80)." ..."}}</div>
                            <p><a style="position:absolute;bottom:5px;left:5px" href="{{route('user.delete.books',['id'=>$user->id,'book_id'=>$book->id,'book_type'=>'lendable'])}}" class="grey-text text-lighten-4  btn-flat weight-400">Remove</a></p>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        <div id="wishlist" class="col s12">
            <div class="row">
                <h5 class=" weight-300">My wishLlist</h5>
                @foreach($my_books as $book)
                @if($book->is_wishlist == '1')
                <div class="col s6 m2">
                    <div class="card  hoverable red darken-2 ">
                        <div class="card-image">
                            <img class="activator" height="150px" src="{{$book->image}}">
                        </div>
                        <div class="card-content red darken-2 ">
                            <p><a style="position:absolute;bottom:5px;left:5px" href="{{route('user.delete.books',['id'=>$user->id,'book_id'=>$book->id,'book_type'=>'wishlist'])}}" class="grey-text text-lighten-4 btn-flat weight-400">Remove</a></p>
                        </div>
                        <div class="card-reveal padding-none">
                            <div class="red row darken-2 padding-2 margin-none">
                            <small class="card-title left font-13 grey-text text-lighten-4">{{substr($book->title,0,11).' ..'}}</small>
                            <i class="card-title grey-text text-lighten-4 mdi-hardware-keyboard-arrow-down right "></i>
                            <div style="clear:both"></div>
                            </div>
                            <div class="weight-300 row white padding-5 margin-none font-12 col s12" style="height:133px">{{substr($book->desc,0,80)." ..."}}</div>
                            <div class="red darken-2 row margin-none">
                                <a href="{{route('user.delete.books',['id'=>$user->id,'book_id'=>$book->id,'book_type'=>'wishlist'])}}" class="grey-text text-lighten-4 btn-flat margin-left-2">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        <div id="bookstore" class="col s12">
            <div class="row">
                <h5 class=" weight-300">My BookStore</h5>
                <input type="hidden" id="csrf_token" value="{{csrf_token()}}">
                @foreach($my_books as $book)
                @if($book->is_sellable == '1')
                <div class="col s6 m2">
                    <div class="card  hoverable red darken-2 ">
                        <div class="card-image">
                            <img class="activator" height="150px" src="{{$book->image}}">
                            <input type="hidden" id="price_{{$book->book_id}}" value="{{$book->selling_price}}">
                            <input type="hidden" id="id_{{$book->book_id}}" value="{{$book->id}}">
                        </div>
                        <div class="card-content red darken-2 ">
                            <a style="position:absolute;bottom:5px;left:5px" href="{{route('user.delete.books',['id'=>$user->id,'book_id'=>$book->id,'book_type'=>'sellable'])}}" class="grey-text text-lighten-4 btn-flat weight-400">Remove</a>
                            <a style="position:absolute;bottom:5px;right:5px" href="" id="{{$book->book_id}}" class="grey-text text-lighten-4 edit btn-flat weight-400">Edit</a>
                        </div>
                        <div class="card-reveal padding-none margin-none">
                            <!-- <div style="position:absolute;top:5px;left:2px"><small class="card-title font-12 grey-text text-darken-4 col s10">{{substr($book->title,0,15).' ...'}}</small></div> -->
                            <!-- <div style="position:absolute;top:5px;right:2px"><i class="card-title mdi-hardware-keyboard-arrow-down "></i></div> -->
                            <!-- <hr style="margin-top:35px;color:#000;background:#000" /> -->
                            <div class="red darken-2 row padding-2 margin-none">
                                <small class="card-title left font-13 grey-text text-lighten-4">{{substr($book->title,0,11).' ..'}}</small>
                                <i class="card-title grey-text text-lighten-4 mdi-hardware-keyboard-arrow-down right "></i>
                                <div style="clear:both"></div>
                            </div>
                            <div class="weight-300 row padding-5 white margin-none font-12 col s12" style="height:133px">{{substr($book->desc,0,100)." ..."}}</div>
                            <div class="red darken-2 row padding-none margin-none">
                                <a href="{{route('user.delete.books',['id'=>$user->id,'book_id'=>$book->id,'book_type'=>'sellable'])}}" class="left grey-text text-lighten-4 btn-flat margin-left-2">Remove</a>
                                <a href="" id="{{$book->book_id}}" class="grey-text text-lighten-4 edit btn-flat right margin-right-2">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
    @else
    <div class="row white padding-20" style="min-height:400px;margin-top:-15px">
        <h5 class="weight-300">Hey!! You do not have any books in your bookshelf.</h5>
        <hr>
        <p>
            You can easily get started by :
            <ul>
                <li>1. Add your location in the system <a href="{{route('dashboard')}}" class="red-text text-darken-2">here.</a></li>
                <li>2. Complete rest of your profile <a href="{{route('user.edit.profile')}}" class="red-text text-darken-2">here.</a></li>
                <li>3. Search for the books of your interest from the search box on the right.</li>
                <li>4. Add the books to your bookshelf / bookstore [to sell] / or wishlist.</li>
            </ul>
        </p>
    </div>
    
    @endif
    <!-- Modal Structure -->
    <div id="modal-sell" class="modal">
        <div class="row modal-content">
            <div class="row">
                <h5 class="weight-300 left">Edit Book price <small class="grey-text text-lighten-1">&nbsp;&nbsp;&nbsp;(upto 2 decimal places. eg 50.00)</small></h5>
                <a href="#!" class="right modal-action modal-close btn-flat margin-right-10"><i class="material-icons">close</i></a>
            </div>
            <br>
            <div class="row">
                <div class="col s12 m8 push-m2">
                    <div class="input-field col s8">
                        <input placeholder="Your price" id="selling_price" name="selling_price" type="number" step="0.01" min="0" class="validate">
                        <label for="selling_price">Earlier Selling Price</label>
                        <span id="error_price" class="grey-text text-lighten-4"></span>
                    </div>
                    <div class="input-field col s4">
                        <a id="selling_btn" class="margin-top--5 btn yellow black-text z-depth-0 btn-block btn-large">Save</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('javascript')
<script>
        editBookPrice = "{{route('edit.book.price',['id'=>'__id__of__the__book__'])}}";
        var book_id;
        var id;
        $(".edit").click(function(e){
            // $('#preloader').show();
            e.preventDefault();
            book_id = $(this).attr("id");
            id = $("#id_"+book_id).val();
            old_sp = $("#price_"+book_id).val();
            $("#selling_price").val(old_sp);
            $('#modal-sell').openModal();
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
                // post_data.selling_price = sp;
                // post_data._token = $("#csrf_token").val();
                post_data = {
                    id : id,
                    book_id : book_id,
                    _token : $("#csrf_token").val(),
                    selling_price : sp,
                }
                editBookPrice = editBookPrice.replace(/__id__of__the__book__/g, post_data.id);
                // console.log(editBookPrice);
                jQuery.ajax({
                    url: editBookPrice,
                    method: "POST",
                    dataType: "json",
                    scriptCharset: "UTF-8",
                    data: post_data,
                    beforeSend: function() {
                        
                    },
                    success: function(a, b, c) {
                        if (a.code == 100) {
                            Materialize.toast(a.message, 5000);
                            $('#modal-sell').closeModal();
                            $("#selling_price").val(sp);
                            return false;
                        }
                        else if (a.code == 101) {
                            Materialize.toast(a.message, 5000);
                            $('#modal-sell').closeModal();
                            return false;
                        }
                    },
                    error: function(a, b, c) {
                        console.log(a);
                        console.log(b);
                        console.log(c);
                        $('#modal-sell').closeModal()
                        Materialize.toast("You are not allowed to make that operation", 5000);
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