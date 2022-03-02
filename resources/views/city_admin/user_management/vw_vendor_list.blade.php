
@extends('city_admin.layout.layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row no-margin">
            <div class="col-md-12  no-pad">
                <section class="content-header">
                    <h1>Vendors List
                        <div class="pull-right">
                            <a href="{{ route('cityadmin.add.vendor') }}"><button type="button" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New 
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
                                        <!-- <th width="15%">City</th> -->
                                        <th width="15%">Store name</th>
                                        <th width="15%">Store owner name</th>
                                        <th width="15%">Address </th>
                                        <th width="20%">Email </th>
                                        <th width="20%">Phone No. </th>
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
    $(".ct_meun").removeClass("active");
    $(".ct_user_management_active").addClass("active");
    $(".ct_vendor_list_active").addClass("active");
</script>
<script type="text/javascript">
  // $(function () {
    let table = $('#example').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('cityadminvendor.getDataTable') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'store_name', name: 'store_name'},
            {data: 'store_owner_name', name: 'store_owner_name'},
            {data: 'vendor_address', name: 'vendor_address'},
            {data: 'vendor_email', name: 'vendor_email'},
            {data: 'vendor_mobile_no', name: 'vendor_mobile_no'},
            {data: 'date', name: 'date'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
  // });

  function reload_table() {
      table.DataTable().ajax.reload(null, false);
   }

 </script>
@endsection