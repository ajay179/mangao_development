@extends('admin.layout.layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row no-margin">
            <div class="col-md-12  no-pad">
                <section class="content-header">
                    <h1>Wallet Offer Plan
                        <div class="pull-right">
                            <a href="{{ route('add.offerplan') }}"><button type="button" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New 
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
                                        <th width="10%">Sr No.</th>
                                        <th width="10%">Offer Amount</th>
                                        <th width="10%">Offer Priority</th>
                                        <th width="8%">Is Offer</th>
                                        <th width="10%">Discount Type</th>
                                        <th width="10%">Amount/Percentage</th>
                                        <th width="15%">Total Calculate Amount</th>
                                        <th width="15%">Offer Image</th>
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
    $(".s_meun").removeClass("active");
    $(".wallet_normal_admin").addClass("active");
    $(".offer_plan_active").addClass("active");
    
</script>


<script type="text/javascript">
  // $(function () {
    let table = $('#example').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('offerplan.getDataTable') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'offer_amount', name: 'offer_amount'},
            {data: 'offer_priority', name: 'offer_priority'},
            {data: 'isoffer_status', name: 'isoffer_status'},
            {data: 'discount_value_type', name: 'discount_value_type'},
            {data: 'discount_amount', name: 'discount_amount'},
            {data: 'total_calculate_offer_amount', name: 'total_calculate_offer_amount'},
            {data: 'offer_plan_image', name: 'offer_plan_image'},
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