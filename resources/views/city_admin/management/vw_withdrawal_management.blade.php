@extends('city_admin.layout.layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row no-margin">
            <div class="col-md-12  no-pad">
                <section class="content-header">
                    <h1>Withdrawal Management</h1>
                </section>
                <section class="content" style="padding:5px 0px;">
                    <div class="box box-primary">
                        <div class="box-body light-green-body">
                            <table id="example" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="7%">Sr No.</th>
                                        <th width="10%">Withdrawal Amount</th>
                                        <th width="10%">Convinence Fees (3%+GST)</th>
                                        <th width="10%">Find Amount transferred</th>
                                        <th width="10%">Date/Time of request</th>
                                        <th width="10%">Date/Time of Settlement</th>
                                        <th width="10%">Transaction ID</th>
                                        <th width="10%">Status</th>
                                        <th width="10%">Reason (If Rejected)</th>
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
    $(".ct_management_active").addClass("active");
    $(".ct_withdrawal_management_active").addClass("active");
</script>
<script type="text/javascript">
  $("#example").dataTable();

 </script>
@endsection