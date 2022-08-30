
$(document).ready(function () {
    $(function () {
        $("#on_screen_notification_form").validate({
            onfocusout: false,
             rules: {
                notification_title: {
                    required: true,
                },
                message: {
                    required: true,
                },
                time_slot_id: {
                    required: true,
                }

            },
            // Specify the validation error messages
            messages: {
                notification_title: {
                    required: '* Please enter notification title.',
                },
                message: {
                    required: '* Please enter message.',
                },
                time_slot_id: {
                    required: '* Please select time slot.',
                }
            },
            submitHandler: function (form) {
                $(".submit").text("Please wait..");
                $(".submit").attr("disabled", true);

               form.submit();
            }
        });
    });
});



    $('#example').on('change','.approvel-btn-status',function() {
        var notification_id = $(this).attr('data-id');
        var notification_status_value = $(this).val();
        if(notification_status_value == 'not_approved'){
            $('#vendor_notification_id').val(notification_id);
            $('#vendor_notification_status').val(notification_status_value);
            $("#myModal").modal('show');
        }else{
            if(notification_id != ''){
                var headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                $.ajax({
                    url: base_url + '/check-on-screen-notification-slot-and-approved',
                    type: "POST",
                    dataType: "json",
                    headers:headers,
                    data:{
                        notification_status_value : notification_status_value,
                        notification_id : notification_id,
                        admin_not_approved_remark : '',
                    },
                    success:function(result) {
                        if (result.status == true) {
                            success_toast('', result.message);
                            reload_table();
                        }    
                    }
                });
            }
        }
    });



    $('#submit_notification_status_form').on('click',function() {
        var notification_id = $('#vendor_notification_id').val();
        var notification_status_value = $('#vendor_notification_status').val();
        var admin_not_approved_remark = $('#admin_not_approved_remark').val();
        
        if(notification_id != '' && notification_status_value != ''){
            var headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            $.ajax({
                url: base_url + '/check-on-screen-notification-slot-and-approved',
                type: "POST",
                dataType: "json",
                headers:headers,
                data:{
                    notification_status_value : notification_status_value,
                    notification_id : notification_id,
                    admin_not_approved_remark : admin_not_approved_remark,
                },
                success:function(result) {
                    if (result.status == true) {
                        $("#myModal").modal('hide');
                        $('#admin_not_approved_remark').val('');
                        success_toast('', result.message);
                        reload_table();
                    }    
                }
            });
        }
    });