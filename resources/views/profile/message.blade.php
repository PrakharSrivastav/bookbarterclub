@extends('layouts.profile')
@section('content')
<div class="margin-none row padding-10" style="min-height:550px">
    <div class="col s12 m2 padding-none">
        <div class="col s12 margin-none padding-none"  style="min-height:540px">
            <div class="collection margin-none">
            	@if(isset($all_data))
            		@foreach($all_data as $sender=>$val)
            			<a href="#!" id="{{str_replace(' ','_',$sender)}}" data-user="{{$val[0]['sender_id']}}" class="collection-item red darken-2 grey-text text-lighten-2 name">{{$sender}}</a>
            		@endforeach
            	@endif
                </div>
            <div style="clear:both"></div>
        </div>
    </div>
    <div class="col s12 m10 padding-none">
        <div class="col s12 margin-none padding-none">
            <div class="row padding-10">
                <form class="col s12">
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea id="message" class="materialize-textarea"></textarea>
                            <label  for="message">Your Message Here</label>
                            <span class="red-text" id="message_error"></span>
                        </div>
                        <input type="hidden" value="" id="message_to">
                        <input type="hidden" value="{{csrf_token()}}" id="csrf_token">
                    </div>
                    <div class="margin-left-10">
                        <button type="button" id="send_message" class="red darken-2 text-grey text-lighten-3 btn">Send</button>
                    </div>
                </form>
            </div>
            <div class="row padding-20">
                <ul class="collection with-header">
                    <li class="collection-header"><h4>Previous Conversations</h4></li>
                    @if(isset($all_data))
	                    @foreach($all_data as $each=>$value)
		                    @foreach($value as $every)
		                    <li class="collection-item {{str_replace(' ','_',$each)}} news">
		                        <div class="">
		                        	<small>{{$every['created_at']}}</small>
		                            <div>{{$every['message']}}</div>
		                        </div>
		                    </li>
		                    @endforeach
	                    @endforeach
                    @endif
                </ul>
                <div style="clear:both"></div>
            </div>
            <div style="clear:both"></div>
        </div>
        <div style="clear:both"></div>
    </div>
    <div style="clear:both"></div>
</div>
@stop
@section('javascript')
<script>
$(".news").hide();
$(document).ready(function($) {
	@if(isset($first_sender['name']) && $first_sender['name'] !="")
	$(".{{$first_sender['name']}}").show();
	$("#message_to").val({{$first_sender['id']}});
	@endif
	
	$("#message").val("");
	$(".name").click(function(e){
		e.preventDefault();
		id = $(this).attr("id");
		to = $(this).attr("data-user");
		$(".news").hide();
		if(id !== "")
			$("."+id).show();
		$("#message_to").val(to);
		$("#message").val("");
	});
	$("#send_message").click(function(e){
		e.preventDefault();
		console.log($("#message_to").val());
		message = $.trim($("#message").val());
		if(message== "" || message == undefined){
			$("#message_error").empty();
			$("#message_error").text("The Message is blank. Please write a message");
		}
		else{
			$("#message_error").empty();
			data = {
				text : message,
				to : $("#message_to").val(),
				_token : $("#csrf_token").val()
			};
			$.ajax({
				url: "{{route('send.message')}}",
				type: 'POST',
				dataType: 'json',
				data: data,
			})
			.done(function(a) {
				Materialize.toast(a.message , 5000);
        		return false;
			})
			.fail(function(a) {
				Materialize.toast("You are not allowed to perform this operation" , 5000);
        		return false;
			})
			.always(function(a) {
				location.reload();
			});
		}
	});
});
</script>
@stop