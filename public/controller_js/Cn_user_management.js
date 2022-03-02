
$(document).ready(function () {
    $(function () {
        $("#vendorForm").validate({
            onfocusout: false,
             rules: {
                category_id: {
                    required: true,
                },
                store_name: {
                    required: true,
                },
                store_owner_name: {
                    required: true,
                },
                vendor_comission: {
                    required: true,
                    number: true,
                },
                vendor_latitude: {
                    required: true,
                },
                vendor_longitude: {
                    required: true,
                  
                },
                 vendor_address: {
                    required: true,
                },
                delivery_range: {
                    required: true,
                    number: true,
                    
                },
                 vendor_email: {
                    required: true,
                    email: true
                },
                vendor_mobile_no: {
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10
                },
                vendor_password: {
                    required: true,
                },
                confirm_password: {
                    required: true,
                    equalTo: "#vendor_password",
                },
                


            },
            // Specify the validation error messages
            messages: {
                category_id: {
                    required: '* Please select ctegory.',
                },
                store_name: {
                    required: '* Please enter store name.',
                },
                store_owner_name: {
                    required: '* Please enter store owner name.',
                },
                vendor_comission: {
                    required: '* Please enter commision.',
                    number: "The commision field only contain numerical digits.",
                },
                vendor_latitude: {
                    required: '* Please enter email id.',
                },
                 vendor_longitude: {
                    required: '* Please enter Longitude.',
                },
                vendor_address: {
                    required: '* Please enter vendor address.',
                },
                delivery_range: {
                    required: '* Please enter delivery range.',
                    number: "The delivery range field only contain delivery range.",
                },
                vendor_email: {
                    required: '* Please enter email id.',
                    email: "* Enter a valid email."
                },

                vendor_mobile_no: {
                    required: '* Please enter mobile no.',
                    number: "The mobile no field only contain numerical digits.",
                   minlength: "The mobile no field only contain 10 digits.",
                   maxlength: "The mobile no field only contain 10 digits."
                },
                vendor_password: {
                    required: '* Please enter password.',
                },
                confirm_password: {
                    required: '* Please confirm password.',
                    equalTo: "* New password and confirm new password does not match."
                },
                
            },
            submitHandler: function (form) {
                $(".submit").text("Please wait..");
                $(".submit").attr("disabled", true);

               form.submit();
            }
        });
    });
});