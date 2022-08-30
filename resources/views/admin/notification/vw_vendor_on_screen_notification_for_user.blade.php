@extends('admin.layout.layout')
@section('content')
<style type="text/css">
    .modal-header, h4, .close {
    background-color: #5cb85c;
    color:white !important;
    text-align: center;
    font-size: 30px;
  }
  .modal-footer {
    background-color: #f9f9f9;
  }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row no-margin">
            <div class="col-md-12  no-pad">
                <section class="content-header">
                    <h1>Vendor Notification List Added For User </h1>
                </section>
                <section class="content" style="padding:5px 0px;">
                    <div class="box box-primary">
                        <div class="box-body light-green-body">
                            <table id="example" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="7%">Sr No.</th>
                                        <th width="15%">Notification Title</th>
                                        <th width="15%">Message</th>
                                        <th width="15%">From Time</th>
                                        <th width="20%">To Time </th>
                                        <th width="20%">Notification Image </th>
                                        <th width="20%">Date </th>
                                        <th width="10%" style="min-width: 80px;" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div> <!-- End box-body -->
                    </div> <!-- End box -->
                </section>
            </div>


        </div>
        <!-- /.row -->
    </section>
</div>

<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: 1px solid #c3a5a5;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3>Add Remark</h3>
        </div>
        <div class="modal-body">
           
            <div class="col-md-12 form-group no-padd">
                <label style="font-size: 16px;">Remark<span style="color: red;">*</span></label>
                <input type="hidden" class="form-control" id="vendor_notification_id" value="">
                <input type="hidden" class="form-control" id="vendor_notification_status" value="">
                <textarea id="admin_not_approved_remark" class="form-control" rows="4"></textarea>
            </div> <!-- End form-group -->
            
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-default btn-success" id="submit_notification_status_form">Submit</button>
          <button type="submit" class="btn btn-default btn-default" data-dismiss="modal"> Cancel</button>
        </div>
      </div>
    </div>
  </div>

<!-- /.row -->
@endsection


@section('js_section')
<script type="text/javascript">
    $(".s_meun").removeClass("active");
    $(".onscreen_notification").addClass("active");
    $(".user_notification").addClass("active");
</script>


 <script type="text/javascript">
  // $(function () {
    let table = $('#example').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('notification-datatable-added-by-vendor','user') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'notification_title', name: 'notification_title'},
            {data: 'message', name: 'message'},
            {data: 'from_time', name: 'from_time'},
            {data: 'to_time', name: 'to_time'},
            {data: 'notification_image_name', name: 'notification_image_name'},
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