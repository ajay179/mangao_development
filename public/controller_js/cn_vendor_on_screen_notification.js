// Get time slot postion 
 $('#schedule_date').on('change',function(){
    var schedule_date = $(this).val();
     
    if(schedule_date != ''){
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        // alert();
        $.ajax({
            url: base_url + '/check-user-schedule-date-notification',
            type: "POST",
            dataType: "json",
            headers:headers,
            data:{
                schedule_date : schedule_date,
                notification_type : "on_screen_notification_promotion",
               
            },
            success:function(result) {
                if(result.status == true){
                    $('#schedule_date_error').html('');
                    $('#notification_submit_btn').attr('disabled',false);
                }
                if(result.status == false){
                    $('#schedule_date_error').html(result.message);
                    $('#notification_submit_btn').attr('disabled',true);
                }
            }
        });
    }
 });


// Get time slot postion 
 $('#time_slot_id').on('change',function(){
    var slot_id = $(this).val();
     var schedule_date = $('#schedule_date').val();
    if(slot_id != ''){
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        // alert();
        $.ajax({
            url: base_url + '/get-slot-position-number-for-notification',
            type: "POST",
            dataType: "json",
            headers:headers,
            data:{
                slot_id : slot_id,
                schedule_date:schedule_date,
                notification_type : "on_screen_notification_promotion",
               
            },
            success:function(result) {
                if(result.status == true){
                    $('#slot_position_number').html(result.sub_category_list);
                    $('#slot_id_error').html('');
                    $('#notification_submit_btn').attr('disabled',false);
                }
                if(result.status == false){
                    $('#slot_position_number').html('<option value="">-- Select Position --</option>');
                    $('#slot_id_error').html(result.message);
                    $('#notification_submit_btn').attr('disabled',true);
                }
            }
        });
    }else{
        $('#slot_position_number').html('<option value="">-- Select Position --</option>');
    }
    
 });



$('#slot_position_number').on('change',function(){
    var slot_position_number = $(this).val();
    var slot_id = $('#time_slot_id').val();
    var schedule_date = $('#schedule_date').val();
    if(slot_id != '' && slot_position_number != ''){
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        // alert();
        $.ajax({
            url: base_url + '/check-slot-booking-and-get-price',
            type: "POST",
            dataType: "json",
            headers:headers,
            data:{
                slot_id : slot_id,
                slot_position_number:slot_position_number,
                notification_type : "on_screen_notification_promotion",
                 schedule_date:schedule_date,
                
            },
            success:function(result) {
                if(result.status == true){
                    $('.slot_info_div').show();
                    $('#from_time').val(result.slot_data.from_time);
                    $('#to_time').val(result.slot_data.to_time);
                    $('#slot_name').val(result.slot_data.slot_name);
                    $('#amount').val(result.slot_data.banners_2_amount);

                    $('#from_time_text').html(result.slot_data.from_time);
                    $('#to_time_text').html(result.slot_data.to_time);
                    $('#slot_name_text').html(result.slot_data.slot_name);
                    $('#amount_text').html(result.slot_data.banners_2_amount);

                    $('#slot_position_number_error').html("");
                    $('#notification_submit_btn').attr('disabled',false);
                }
                if(result.status == false){
                    $('.slot_info_div').hide();
                    $('#slot_position_number_error').html(result.message);
                    $('#notification_submit_btn').attr('disabled',true);
                }
            }
        });
    }
    
 });



 
