@extends('vendor.layout.layout')
@section('content')

<style type="text/css">
    .slot_info_div{
        display: none;
    }
</style>

 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <section class="content-header">
                    <h1>Add User Notification </h1>
                </section>

                <div class="box box-primary">
                    <div class="box-body light-green-body mob_min_height_auto">
                          <form method="POST" id="cityForm" enctype='multipart/form-data' action="{{ url('vendor-to-user-notification-action') }}" >
                          @csrf
                        
                            <div class="col-md-12 form-group no-padd">
                                <label>Notification Title<span style="color: red;">*</span></label>
                                <input type="text" name="notification_title" id="notification_title" autocomplete="off" class="form-control" value="">
                                <input type="hidden" name="user_type" value="user">
                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->
                            <div class="clearfix"></div>


                            <div class="col-md-12 form-group no-padd">
                                <label> Message<span style="color: red;">*</span></label>
                                <textarea  name="message" rows="6" id="message" autocomplete="off" class="form-control" value=""> </textarea>
                               
                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->


                            <div class="col-md-12 form-group no-pad">
                              <div class="upload_img">
                                  <div class="upload_photo">
                                      <label>Image <span style="color: red;">*</span></label>
                                      <input type="file" name="notification_image" accept=".jpg,.jpeg,.bmp,.png," id="notification_image" onchange="change_img('notification_image','fileold')" class="form-control">
                                      
                                  </div>
                                  <input type="hidden" class="form-control">

                                  <div class="img-preview">
                                      <div class="photo p-relative">
                                          <img id="fileold" name="fileold" src="{{ asset('commonarea/dist/img/default.png') }} " alt="image" style="height:100px; width:140px; margin-top:5px;object-fit: cover;" class="profile-img4">
                                      </div>
                                  </div>
                                </div>
                            </div>

                             <div class="col-md-12 form-group no-padd">
                                <label>Date<span style="color: red;">*</span></label>
                                <input type="text" name="schedule_date" id="schedule_date" autocomplete="off" class="form-control" value="">
                               
                                <div class="text-danger" id="schedule_date_error"></div>
                            </div> <!-- End form-group -->

                            <div class="col-md-12 form-group no-pad">
                                <label>Select Slot<span style="color: red;">*</span></label>
                                @php $time_slot_id =  !empty($cityadmin_data[0]->time_slot_id) ? $cityadmin_data[0]->time_slot_id :  '' @endphp
                                <select class="form-control" name="time_slot_id" id="time_slot_id">
                                    <option value="">Select Slot</option>
                                    @if (!empty($slot_list_data)) 
                                       @foreach ($slot_list_data as $key => $value)
                                            <option value="{{ $value['id'] }}"  @if ($value->id == $time_slot_id) selected @endif> {{ ucwords($value['slot_name']) }}</option>
                                       @endforeach
                                    @endif
                                </select>
                                <div class="text-danger" id="slot_id_error"></div>
                            </div>

                            <div class="col-md-12 form-group no-pad">
                                <label>Select Slot Position Number<span style="color: red;">*</span></label>
                                <select class="form-control" name="slot_position_number" id="slot_position_number">
                                    <option value="">-- Select Position --</option>
                                   
                                </select>
                                <div class="text-danger" id="slot_position_number_error"></div>
                            </div>

                            <div class="col-md-12 form-group slot_info_div" >

                                <span><b>Amount :- </b><span id="amount_text">100</span></span>
                                <!-- <span style="margin-left: 40px;"><b>Slot Name :-</b> <span id="slot_name_text">100</span></span> -->
                            </div>
                            <div class="col-md-12 form-group slot_info_div" >
                                <!-- <span><b>From Time :- </b><span id="from_time_text">100</span></span>
                                <span style="margin-left: 40px;"><b>To Time :-</b> <span id="to_time_text">100</span></span> -->
                                
                                <input type="hidden" name="slot_amount" id="slot_amount" value="">
                            </div>

                            <div class="col-md-12 form-group no-padd">
                                <button type="submit" id="notification_submit_btn" class="btn btn-success save_btn submit sub-btn" data-id="submit">Send Notification</button>
                                <a href=""> <button type="button" class="btn btn-danger cancel-btn"><i class="fa fa-times-circle"></i> Cancel</button></a>
                            </div> <!-- End form-group -->
                          </form>
                    </div> <!-- End box-body -->
                </div> <!-- End box -->
            </div>

            <div class="col-md-8 ">
                <section class="content-header">
                    <h1>User Notification List </h1>

                </section>
                <div class="box box-primary">
                    
                        <div class="box-body">

                            <div class="">

                                <div class="row">
                                    <div class="col-sm-12">
                                       <div class="table-responsive">
                                          <table id="example" class="table table-bordered">
                                             <thead>
                                                   <tr role="row">
                                                      <th width="3%" class="text-center">Sr No.</th>
                                                      <th width="10%">Notification</th>
                                                      <th width="15%" >Message</th>
                                                      <th width="5%" >Date</th>
                                                      <th width="1%" >Action</th>
                                                   </tr>
                                             </thead>
                                             
                                          </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                   
                </div> <!-- End box-body -->
            </div> <!-- End box -->
        </div>
    </section>
</div>
<!-- /.row -->
@endsection


@section('js_section')
<script type="text/javascript">
    $(".s_meun").removeClass("active");
    $('.promotion_management_menu').addClass('active');
    $(".on_screen_notification").addClass("active");
     $(document).ready(function() {

        $('#schedule_date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            changeMonth: true,
            changeYear: true,
            mindate:0,
        });
    });
</script>

<script type="text/javascript">
  // $(function () {
    let table = $('#example').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('get-vendor-to-user-notification-datatable','user') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'notification_title', name: 'notification_title'},
            {data: 'message', name: 'message'},
            {data: 'date', name: 'date'},
            {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
  // });

  function reload_table() {
      table.DataTable().ajax.reload(null, false);
   }

 </script>
@endsection