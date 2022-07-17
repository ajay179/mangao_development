@extends('city_admin.layout.layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row no-margin">
            <div class="col-md-12  no-pad">
                <section class="content-header">
                    <h1>Ongoing Orders

                    <div class="pull-right">
                            <a href="">
                                <button type="button" class="btn btn-primary jobCard_view" id="pending" style="padding-right: 7px;">
                                    <i class="fa fa-clock-o"></i> <span class="pr-5">Pending</span> <span class="lk-cnts"> 0</span>
                                </button>
                            </a>
                            <a href="">
                                <button type="button" class="btn btn-default jobCardInprocess_view" id="pending" style="padding-right: 7px;">
                                    <i class="fa fa-signal"></i> <span class="pr-5">Ongoing</span> <span class="lk-cnts">0</span>
                                </button>
                            </a>
                             <a href="">
                                <button type="button" class="btn btn-default jobCrdCompleted_view" id="pending" style="padding-right: 7px;">
                                    <i class="fa fa-check"></i> <span class="pr-5">Completed</span> <span class="lk-cnts">0 </span>
                                </button>
                            </a>
                            <a href="">
                                <button type="button" class="btn btn-default jobCardHardnessTesting_view" id="pending" style="padding-right: 7px;">
                                    <i class="fa fa-clock-o"></i> <span class="pr-5">Scheduled</span> <span class="lk-cnts"> 0</span>
                                </button>
                            </a>
                            
                            <a href="">
                                <button type="button" class="btn btn-default jobCardHardnessTesting_view" id="pending" style="padding-right: 7px;">
                                    <i class="fa fa-clock-o"></i> <span class="pr-5">Cancelled & Returned</span> <span class="lk-cnts"> 0</span>
                                </button>
                            </a>

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
                                        <th width="10%">Order ID</th>
                                        <th width="10%">City Name</th>
                                        <th width="10%">Store Name</th>
                                        <th width="10%">Store Type</th>
                                        <th width="10%">User Name</th>
                                        <th width="10%">Email</th>
                                        <th width="10%">Mobile No.</th>
                                        <th width="10%">Email</th>
                                        <th width="10%">Order Amount</th>
                                        <th width="10%">No. of items</th>
                                        <th width="10%">Date/Time </th>
                                        <th width="10%">Order Type</th>
                                        <th width="10%">Order Status</th>
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
  $("#example").dataTable();

 </script>
@endsection