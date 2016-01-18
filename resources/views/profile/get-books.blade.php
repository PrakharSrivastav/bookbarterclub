@extends('layouts.profile')
@section('content')
<div class="col s12 grey padding-none margin-none margin-top-10 lighten-2" style="height:auto; overflow:hidden;min-height:400px">
    @if(isset($my_books) && count($my_books)>0)
    <div class="row grey lighten-2 margin-none padding-none">
        <div class="col s12 margin-none padding-none">
            <ul class="tabs padding-none margin-none" style="overflow:hidden">
                <li class="tab col s4 grey lighten-1"><a href="#mybooks" class="black-text active">My Books</a></li>
                <li class="tab col s4 grey lighten-1"><a class="black-text"href="#wishlist">My Wishlist</a></li>
                <li class="tab col s4 grey lighten-1"><a href="#bookstore" class="black-text">My Bookstore</a></li>
            </ul>
        </div>
        <div id="mybooks" class="col s12">
            <div class="row">
                <h5 class=" weight-300">My Books Available for lending</h5>
                @foreach($my_books as $book)
                @if($book->is_lendable == '1')
                <div class="col s6 m2">
                    <div class="card  hoverable yellow lighten-1 ">
                        <div class="card-image waves-effect waves-block waves-light yellow lighten-1 ">
                            <img class="activator weight-300" height="150px" src="{{$book->image}}">
                            @if($book->image == "https://s.gr-assets.com/assets/nophoto/book/111x148-bcc042a9c91a29c1d680899eff700a03.png")
                            <span style="position:absolute;top:5px;right:5px" class="black-text card-title padding-5 weight-400">{{substr($book->title,0,30).' ...'}}</span>
                            @endif
                        </div>
                        <div class="card-content yellow lighten-1 ">
                            <a style="position:absolute;bottom:5px;left:5px" href="{{route('user.delete.books',['id'=>$user->id,'book_id'=>$book->id,'book_type'=>'lendable'])}}" class="red-text btn-flat weight-400">Remove</a>
                        </div>
                        <div class="card-reveal yellow lighten-1 ">
                            <div style="position:absolute;top:5px;left:5px"><span class="card-title padding-none margin-none grey-text text-darken-4 col s10">{{substr($book->title,0,30).' ...'}}</span></div>
                            <div style="position:absolute;top:5px;right:5px"><i class="card-title mdi-hardware-keyboard-arrow-down "></i></div>
                            <p><a style="position:absolute;bottom:5px;left:5px" href="{{route('user.delete.books',['id'=>$user->id,'book_id'=>$book->id,'book_type'=>'lendable'])}}" class="red-text  btn-flat weight-400">Remove</a></p>
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
                    <div class="card  hoverable yellow lighten-1 ">
                        <div class="card-image waves-effect waves-block waves-light yellow lighten-1 ">
                            <img class="activator" height="150px" src="{{$book->image}}">
                            @if($book->image == "https://s.gr-assets.com/assets/nophoto/book/111x148-bcc042a9c91a29c1d680899eff700a03.png")
                            <span style="position:absolute;top:5px;right:5px" class="black-text card-title padding-5 weight-400">{{substr($book->title,0,30).' ...'}}</span>
                            @endif
                        </div>
                        <div class="card-content yellow lighten-1 ">
                            <p><a style="position:absolute;bottom:5px;left:5px" href="{{route('user.delete.books',['id'=>$user->id,'book_id'=>$book->id,'book_type'=>'wishlist'])}}" class="red-text btn-flat weight-400">Remove</a></p>
                        </div>
                        <div class="card-reveal yellow lighten-1 ">
                            <div style="position:absolute;top:5px;left:5px"><span class="card-title padding-none margin-none grey-text text-darken-4 col s10">{{substr($book->title,0,30).' ...'}}</span></div>
                            <div style="position:absolute;top:5px;right:5px"><i class="card-title mdi-hardware-keyboard-arrow-down "></i></div>
                            <!-- <span class="card-title grey-text  padding-none margin-none  text-darken-4"><i class="mdi-hardware-keyboard-arrow-down right"></i>{{substr($book->title,0,30).' ...'}}</span> -->
                            <p><a href="{{route('user.delete.books',['id'=>$user->id,'book_id'=>$book->id,'book_type'=>'wishlist'])}}" class="red-text  btn-flat weight-300" style="position:absolute;bottom:5px;left:15px">Remove</a></p>
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
                    <div class="card  hoverable yellow lighten-1 ">
                        <div class="card-image waves-effect waves-block waves-light yellow lighten-1 ">
                            <img class="activator" height="150px" src="{{$book->image}}">
                            @if($book->image == "https://s.gr-assets.com/assets/nophoto/book/111x148-bcc042a9c91a29c1d680899eff700a03.png")
                            <span style="position:absolute;top:5px;right:5px" class="black-text card-title padding-5 weight-400">{{substr($book->title,0,30).' ...'}}</span>
                            @endif
                            <input type="hidden" id="price_{{$book->book_id}}" value="{{$book->selling_price}}">
                            <input type="hidden" id="id_{{$book->book_id}}" value="{{$book->id}}">
                        </div>
                        <div class="card-content yellow lighten-1 ">
                            <a style="position:absolute;bottom:5px;left:5px" href="{{route('user.delete.books',['id'=>$user->id,'book_id'=>$book->id,'book_type'=>'sellable'])}}" class="red-text btn-flat weight-400">Remove</a>
                            <a style="position:absolute;bottom:5px;right:5px" href="" id="{{$book->book_id}}" class="red-text edit btn-flat weight-400">Edit</a>
                        </div>
                        <div class="card-reveal yellow lighten-1 row padding-none margin-none">
                            <div style="position:absolute;top:5px;left:5px"><span class="card-title padding-none margin-none grey-text text-darken-4 col s10">{{substr($book->title,0,30).' ...'}}</span></div>
                            <div style="position:absolute;top:5px;right:5px"><i class="card-title mdi-hardware-keyboard-arrow-down "></i></div>
                            <a href="{{route('user.delete.books',['id'=>$user->id,'book_id'=>$book->id,'book_type'=>'sellable'])}}" class="red-text  btn-flat weight-300" style="position:absolute;bottom:5px;left:15px">Remove</a>
                            <a style="position:absolute;bottom:5px;right:5px" href="" id="{{$book->book_id}}" class="red-text edit btn-flat weight-400">Edit</a>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
    @else
    <h5 class="weight-300">Hi!! You do not have any books in your bookshelf.</h5>
    <p>
    You can easily get started by :
    <ul>
        <li>1. Add your location in the system <a href="{{route('dashboard')}}" class="red-text text-darken-2">here.</a></li>
        <li>2. Complete rest of your profile <a href="{{route('user.edit.profile')}}" class="red-text text-darken-2">here.</a></li>
        <li>3. Search for the books of your interest from the search box on the right.</li>
        <li>4. Add the books to your bookshelf / bookstore [to sell] / or wishlist.</li>
    </ul>
    </p>
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