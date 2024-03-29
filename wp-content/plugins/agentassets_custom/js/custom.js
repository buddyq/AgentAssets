jQuery(document).ready(function(){
    jQuery("#micu_signup_form").validate({
            rules: {
                    micu_username: {
                            required: true,
                            minlength: 6
			    
                    },
		    micu_username_same: {
                            required: true,
                            minlength: 6
			    
                    },
                    micu_name: {
                            required: true
                    },
                    micu_email: {
                            required: true,
                            email: true
                    },
                    micu_email_confirm: {
                            required: true,
                            email: true,
                            equalTo: "#micu_email"
                    },
                    micu_pwd: {
                            required: true,
                            minlength: 6
                    },
                    micu_pwd_confirm: {
                            required: true,
                            minlength: 6,
                            equalTo: "#micu_pwd"
                    },
                    
                    micu_broker: {
                            required: true
                    },
                    micu_billing_address_1: {
                            required: true
                    },
                    micu_billing_city: {
                            required: true
                    },
                    micu_billing_state: {
                            required: true
                    },
                    micu_billing_zip: {
                            required: true
                    },
                    micu_billing_email: {
                            required: true,
                            email: true
                    }
            },
            messages: {
                    micu_username: {
                            required: "Please enter a username",
                            minlength: "Your username must consist of at least 6 characters"
                    },
		    micu_username_same: {
                            required: "Username already exists. Please enter a different username",
                            minlength: "Your username must consist of at least 6 characters"
                    },
                    micu_pwd: {
                            required: "Please provide a password",
                            minlength: "Your password must be at least 6 characters long"
                    },
                    micu_pwd_confirm: {
                            required: "Please confirm your password",
                            minlength: "Your password must be at least 6 characters long",
                            equalTo: "Please enter the same password as above"
                    },
                    micu_email: {
                            required: "Please provide an email",
                            email: "Please provide a valid email"
                    },
                    micu_email_confirm: {
                            required: "Please confirm your email",
                            email: "Please provide a valid email",
                            equalTo: "Please enter the same email as above"
                    },
                    micu_name: {
                            required: "Please provide a name"
                    },
                    micu_broker: {
                            required: "Please provide a broker"
                    },
                    micu_billing_address_1: {
                            required: "Please provide a billing address 1"
                    },
                    micu_billing_city: {
                            required: "Please provide a billing city"
                    },
                    micu_billing_state: {
                            required: "Please provide a billing state"
                    },
                    micu_billing_zip: {
                            required: "Please provide a billing zip"
                    },
                    micu_billing_email: {
                            required: "Please provide a billing email",
                            email: "Please provide a valid billing email"
                    }
            }
    }); 
});
/*
//listen for the button to be clicked
jQuery("#form-submit").click(function(event) {
//search for the text area and get its text
var text = jQuery(this).parent().find("#micu_email").val();
//send the text to the server file
jQuery.post("../includes/shortcodes/register-form.php", {email:email},
 function(result) {
if(result == 1) {
alert("success");
}
else {
alert("fail");
}
 });
});
*/

