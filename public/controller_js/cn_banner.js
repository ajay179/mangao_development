
$(document).ready(function () {
    $(function () {
        $("#bannerForm").validate({
            onfocusout: false,
             rules: {
                
                banner_name: {
                    required: true,
                },
                banner_position: {
                    required: true,
                },
                

            },
            // Specify the validation error messages
            messages: {
               
                banner_name: {
                    required: '* Please enter Banner Name.',
                },
                banner_position: {
                    required: '* Please enter Banner position .',
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