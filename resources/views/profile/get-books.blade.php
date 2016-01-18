@extends('layouts.profile')
@section('content')
<div class="col s12 padding-top-5 margin-top-10 grey lighten-2" style="height:auto; overflow:hidden;min-height:400px">
    @if(isset($my_books) && count($my_books)>0)
    <div class="row">
        <h5 class=" weight-300">My Books</h5>
        @foreach($my_books as $book)
        @if($book->is_lendable == '1')
        <div class="col s6 m2">
            <div class="card  hoverable yellow lighten-1 ">
                <div class="card-image waves-effect waves-block waves-light yellow lighten-1 ">
                    <img class="activator weight-300" height="150px" src="{{$book->image}}">
                </div>
                <div class="card-content yellow lighten-1 ">
                    <a style="position:absolute;bottom:5px;left:5px" href="{{route('user.delete.books',['id'=>$user->id,'book_id'=>$book->id])}}" class="red-text btn-flat weight-400">Remove</a>

                </div>
                <div class="card-reveal yellow lighten-1 ">
                    <span class="card-title grey-text text-darken-4"><i class="mdi-hardware-keyboard-arrow-down right"></i>{{$book->title}}</i></span>
                    <p><a style="position:absolute;bottom:5px;left:5px" href="{{route('user.delete.books',['id'=>$user->id,'book_id'=>$book->id])}}" class="red-text  btn-flat weight-400">Remove</a></p>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
    <hr/>
    <div class="row">
        <h5 class=" weight-300">My wishLlist</h5>
        @foreach($my_books as $book)
        @if($book->is_wishlist == '1')
        <div class="col s6 m2">
            <div class="card  hoverable yellow lighten-1 ">
                <div class="card-image waves-effect waves-block waves-light yellow lighten-1 ">
                    <img class="activator" height="150px" src="{{$book->image}}">
                </div>
                <div class="card-content yellow lighten-1 ">
                    <p><a style="position:absolute;bottom:5px;left:5px" href="{{route('user.delete.books',['id'=>$user->id,'book_id'=>$book->id])}}" class="red-text btn-flat weight-400">Remove</a></p>
                </div>
                <div class="card-reveal yellow lighten-1 ">
                    <span class="card-title grey-text text-darken-4"><i class="mdi-hardware-keyboard-arrow-down right"></i>{{$book->title}}</span>
                    <p><a href="{{route('user.delete.books',['id'=>$user->id,'book_id'=>$book->id])}}" class="red-text  btn-flat weight-300" style="position:absolute;bottom:5px;left:15px">Remove</a></p>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
    <hr/>
    <div class="row">
        <h5 class=" weight-300">My BookStore</h5>
        <input type="hidden" id="csrf_token" value="{{csrf_token()}}">
        @foreach($my_books as $book)
        @if($book->is_sellable == '1')
        <div class="col s6 m2">
            <div class="card  hoverable yellow lighten-1 ">
                <div class="card-image waves-effect waves-block waves-light yellow lighten-1 ">
                    <img class="activator" height="150px" src="{{$book->image}}">
                    <input type="hidden" id="price_{{$book->book_id}}" value="{{$book->selling_price}}">
                    <input type="hidden" id="id_{{$book->book_id}}" value="{{$book->id}}">
                </div>
                <div class="card-content yellow lighten-1 ">
                    <a style="position:absolute;bottom:5px;left:5px" href="{{route('user.delete.books',['id'=>$user->id,'book_id'=>$book->id])}}" class="red-text btn-flat weight-400">Remove</a>
                    <a style="position:absolute;bottom:5px;right:5px" href="" id="{{$book->book_id}}" class="red-text edit btn-flat weight-400">Edit</a>
                </div>
                <div class="card-reveal yellow lighten-1 ">
                    <span class="card-title grey-text text-darken-4"><i class="mdi-hardware-keyboard-arrow-down right"></i>{{$book->title}}</span>
                    <a href="{{route('user.delete.books',['id'=>$user->id,'book_id'=>$book->id])}}" class="red-text  btn-flat weight-300" style="position:absolute;bottom:5px;left:15px">Remove</a>
                    <a style="position:absolute;bottom:5px;right:5px" href="" id="{{$book->book_id}}" class="red-text edit btn-flat weight-400">Edit</a>
                </div>
            </div>
        </div>
        @endif
        @endforeach
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
    $('#preloader').show();
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