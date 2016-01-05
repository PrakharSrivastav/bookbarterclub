// This file contains the validations for the front end applicatiion
var validator_0 = $('#login_form').validate({
    rules: {
        password: {
            required: true,
            minlength: 3
        },
        email: {
            required: true,
            email: true
        }
    },
    messages: {
        password: {
            required: "<div style='color:red;font-weight:400;'>Please provide the password.</div>",
            minlength: "<div style='color:red;font-weight:400;'>Password should have atleast 3 characters.</div>"
        },
        email: {
            required: "<div style='color:red;font-weight:400;'>Please provide us your email address.</div>",
            digits: "<div style='color:red;font-weight:400;'>Please provide a valid email adress</div>"
        }
    },
    errorElement:"span"
});

var validator_1 = $("#registration_form").validate({
	errorElement:"span",
	rules : {
		name : { required:true , minlength:3},
		email : {required:true , email:true},
		password : {required:true , minlength:3},
		password_confirmation : {required:true , minlength:3, equalTo: "#password"}
	},
	messages : {
		name : { required:"<div style='color:red;font-weight:400;'>Please provide the name.</div>" , minlength:"<div style='color:red;font-weight:400;'>Name should have atleaset 3 characters.</div>"},
		email : {required:"<div style='color:red;font-weight:400;'>Please provide the email.</div>" , email:"<div style='color:red;font-weight:400;'>Invalid email format.</div>"},
		password : {required:"<div style='color:red;font-weight:400;'>Please provide the password.</div>" , minlength:"<div style='color:red;font-weight:400;'>Password should have atleast 3 characters.</div>"},
		password_confirmation : {required:"<div style='color:red;font-weight:400;'>Please provide the confirmed password field.</div>" , minlength:"<div style='color:red;font-weight:400;'>Confirmed Password should have atleast 3 characters.</div>", equalTo: "<div style='color:red;font-weight:400;'>Password does not match confirmed password.</div>"}
	}
});