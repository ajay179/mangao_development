
$(document).ready(function () {
    $(function () {
        $("#vendorCategoryForm").validate({
            onfocusout: false,
             rules: {
                
                vendor_category_name: {
                    required: true,
                },
                
            },
            // Specify the validation error messages
            messages: {
               
                vendor_category_name: {
                    required: '* Please enter Category Name.',
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



$(document).ready(function () {
    $(function () {
        $("#vendorSubCategoryForm").validate({
            onfocusout: false,
             rules: {
                
                category_name: {
                    required: true,
                },
                
            },
            // Specify the validation error messages
            messages: {
               
                category_name: {
                    required: '* Please enter Category Name.',
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