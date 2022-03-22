$(document).ready(function () {
    $(function () {
        $("#vendorAddProductForm").validate({
            onfocusout: false,
             rules: {
                vendor_category_id: {
                    required: true,
                },
                vendor_sub_category_id: {
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
                stock: {
                    required: true,
                },
                

            },
            // Specify the validation error messages
            messages: {
                vendor_category_id: {
                    required: '* Please select category.',
                },
                vendor_sub_category_id: {
                    required: '* Please select sub category.',
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
                stock: {
                    required: '* Please enter stock.',
                },
            },
            submitHandler: function (form) {
                $(".submit").text("Please wait..");
                $(".submit").attr("disabled", true);

               form.submit();
            }
        });


        $("#vendorProductVariantForm").validate({
            onfocusout: false,
             rules: {
                
                variant_quantity: {
                    required: true,
                },
                variant_price: {
                    required: true,
                },
                variant_offer_price: {
                    required: true,
                    // max: '#price'
                    max: function() {
                        return parseInt($('#variant_price').val());
                    }
                },
                variant_unit: {
                    required: true,
                },
                variant_stock: {
                    required: true,
                },
                

            },
            // Specify the validation error messages
            messages: {
                
                variant_quantity: {
                    required: '* Please enter quantity.',
                },
                variant_price: {
                    required: '* Please enter price.',
                },
                variant_offer_price: {
                    required: '* Please enter offer price.',
                    max:'* Offer price should be less than price'
                },
                variant_unit: {
                    required: '* Please enter unit.',
                },
                variant_stock: {
                    required: '* Please enter stock.',
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

// Get subcategory on category
 $('#vendor_category_id').on('change',function(){
    var category_id = $(this).val();
    if(category_id != ''){
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        // alert();
        $.ajax({
            url: base_url + '/get-sub-category-list-on-category-id',
            type: "POST",
            dataType: "json",
            headers:headers,
            data:{
                category_id : category_id,
            },
            success:function(result) {
                if(result.status == true){
                    $('#vendor_sub_category_id').html(result.sub_category_list);
                }
                if(result.status == false){
                    $('#vendor_sub_category_id').html('<option value="">Select Sub Category </option>');
                }
            }
        });
    }else{
        $('#vendor_sub_category_id').html('<option value="">Select Sub Category </option>');
    }
    
 });