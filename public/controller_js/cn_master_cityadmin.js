
$(document).ready(function () {
    $(function () {
        $("#cityForm").validate({
            onfocusout: false,
             rules: {
                city_name: {
                    required: true,
                },
                city_name: {
                    required: true,
                },
                city_name: {
                    required: true,
                },
                city_name: {
                    required: true,
                },
                city_name: {
                    required: true,
                },
                city_name: {
                    required: true,
                },
                city_name: {
                    required: true,
                },
                city_name: {
                    required: true,
                },
                city_name: {
                    required: true,
                },


            },
            // Specify the validation error messages
            messages: {
                city_name: {
                    required: '* Please select city.',
                },
                city_name: {
                    required: '* Please select city.',
                },
                city_name: {
                    required: '* Please select city.',
                },
                city_name: {
                    required: '* Please select city.',
                },
                city_name: {
                    required: '* Please select city.',
                },
                city_name: {
                    required: '* Please select city.',
                },
                city_name: {
                    required: '* Please select city.',
                },
                city_name: {
                    required: '* Please select city.',
                },
                city_name: {
                    required: '* Please select city.',
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