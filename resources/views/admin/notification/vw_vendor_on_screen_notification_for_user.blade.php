@extends('admin.layout.layout')
@section('content')

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


<!-- /.row -->
@endsection


@section('js_section')
<script type="text/javascript">
    $(".s_meun").removeClass("active");
    $(".orders_management_active").addClass("active");
    $(".ongoing_order_menu").addClass("active");
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