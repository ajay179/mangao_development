$(document).ready(function () {
    $(function () {
        $("#vendorAddRestaurantProductForm").validate({
            onfocusout: false,
             rules: {
                vendor_category_id: {
                    required: true,
                },
                product_name: {
                    required: true,
                },
                quantity: {
                    required: true,
                },
                price: {
                    required: true,
                },
                offer_price: {
                    required: true,
                    // max: '#price'
                    max: function() {
                        return parseInt($('#price').val());
                    }
                },
                product_description: {
                    required: true,
                },
                unit: {
                    required: true,
                },
                

            },
            // Specify the validation error messages
            messages: {
                vendor_category_id: {
                    required: '* Please select category.',
                },

                product_name: {
                    required: '* Please enter product name.',
                },
                 quantity: {
                    required: '* Please enter quantity.',
                },
                price: {
                    required: '* Please enter price.',
                },
                offer_price: {
                    required: '* Please enter offer price.',
                    max:'* Offer price should be less than price'
                },
                product_description: {
                    required: '* Please product description.',
                },
                unit: {
                    required: '* Please enter unit.',
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


    