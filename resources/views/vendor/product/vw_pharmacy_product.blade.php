
@extends('vendor.layout.layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row no-margin">
            <div class="col-md-12  no-pad">
                <section class="content-header">
                    <h1>Product List
                        <div class="pull-right">
                            <a href="{{ route('vendor.add.pharmacy.product') }}"><button type="button" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New Product
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
                                        <th width="15%">Category</th>
                                        <th width="15%">Product Name </th>
                                        <th width="15%">Product Image </th>
                                        <th width="10%">Price </th>
                                        <th width="10%">Offer Price </th>
                                        <th width="6%">Status</th>
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
    $(".products_active").addClass("active");

</script>
<script type="text/javascript">
  // $(function () {
    let table = $('#example').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('vendor.pharmacy.product.getDataTable') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'vendor_category_name', name: 'vendor_category_name'},
            {data: 'product_name', name: 'product_name'},
            {data: 'product_image', name: 'product_image'},
            {data: 'price', name: 'price'},
            {data: 'offer_price', name: 'offer_price'},
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