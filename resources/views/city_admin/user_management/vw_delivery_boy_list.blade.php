
@extends('city_admin.layout.layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row no-margin">
            <div class="col-md-12  no-pad">
                <section class="content-header">
                    <h1>City Admin
                        <div class="pull-right">
                            <a href="{{ route('cityadmin.add.delivery.boy') }}"><button type="button" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New 
                                </button></a>
                        </div>
                    </h1>
                </section>
                <section class="content" style="padding:5px 0px;">
                    <div class="box box-primary">
                        <div class="box-body light-green-body">
                            <table id="example" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                       <th width="7%">Sr No.</th>
                                        <th width="15%">City Name</th>
                                        <th width="15%">Name</th>
                                        <th width="10%">Email </th>
                                        <th width="13%">Phone No. </th>
                                        <th width="13%">Wallet Amount</th>
                                        <th width="13%">Total Amount Settled</th>
                                        <th width="13%">Tip Earned</th>
                                        <th width="13%">Total Orders (Completed)</th>
                                        <th width="13%">Ratings</th>
                                        <th width="10%">Status </th>
                                        <th width="10%">Date </th>
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
    $(".ct_meun").removeClass("active");
    $(".ct_user_management_active").addClass("active");
    $(".ct_delivery_boy_list_active").addClass("active");
    $('#example').dataTable({});
</script>
<!-- <script type="text/javascript">
  // $(function () {
    let table = $('#example').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('cityadmin.getDataTable') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'admin_name', name: 'admin_name'},
            {data: 'admin_mobile', name: 'admin_mobile'},
            {data: 'admin_email', name: 'admin_email'},
            {data: 'admin_image', name: 'admin_image'},
            {data: 'date', name: 'date'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
  // });

  function reload_table() {
      table.DataTable().ajax.reload(null, false);
   }

 </script> -->
@endsection