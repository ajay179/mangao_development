@extends('admin.layout.layout')
@section('content')


 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <section class="content-header">
                    <h1>Add Vendor Notification </h1>
                </section>

                <div class="box box-primary">
                    <div class="box-body light-green-body mob_min_height_auto">
                          <form method="POST" id="cityForm" action="{{ url('notification-action') }}">
                          @csrf
                        
                            <div class="col-md-12 form-group no-padd">
                                <label>Notification<span style="color: red;">*</span></label>
                                <input type="text" name="notification_title" id="notification_title" autocomplete="off" class="form-control" value="">
                                <input type="hidden" name="user_type" value="vendor">
                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->
                            <div class="clearfix"></div>


                            <div class="col-md-12 form-group no-padd">
                                <label> Message<span style="color: red;">*</span></label>
                                <textarea  name="message" rows="6" id="message" autocomplete="off" class="form-control" value=""> </textarea>
                               
                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->


                            <div class="col-md-12 form-group no-padd">
                                <button type="submit" id="submit_btn" class="btn btn-success save_btn submit sub-btn" data-id="submit">Send Notification</button>
                                <a href=""> <button type="button" class="btn btn-danger cancel-btn"><i class="fa fa-times-circle"></i> Cancel</button></a>
                            </div> <!-- End form-group -->
                          </form>
                    </div> <!-- End box-body -->
                </div> <!-- End box -->
            </div>

            <div class="col-md-8 ">
                <section class="content-header">
                    <h1>City List </h1>

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
    $(".onscreen_notification").addClass("active");
    $(".vendor_notification").addClass("active");
</script>

<script type="text/javascript">
  // $(function () {
    let table = $('#example').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('notification-datatable','vendor') }}",
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