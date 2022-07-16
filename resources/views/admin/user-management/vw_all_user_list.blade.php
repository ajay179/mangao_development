@extends('admin.layout.layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row no-margin">
            <div class="col-md-12  no-pad">
                <section class="content-header">
                    <h1>User List
                       
                    </h1>
                </section>
                <section class="content" style="padding:5px 0px;">
                    <div class="box box-primary">
                        <div class="box-body light-green-body">
                            <table id="example" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="7%">Sr No.</th>
                                        <th width="10%">City Name</th>
                                        <th width="10%">Name</th>
                                        <th width="10%">Mobile No.</th>
                                        <th width="10%">Email</th>
                                        <th width="8%">Wallet Amount </th>
                                        <th width="8%">Total Orders (Completed) </th>
                                        <th width="8%">Create Date/Time </th>
                                        <th width="10%" style="min-width: 80px;" class="text-center">Action</th>
                                        <th width="10%">Status </th>
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
    $(".user_management_master").addClass("active");
    $(".all_user_active").addClass("active");
</script>
<script type="text/javascript">
  $("#example").dataTable();

 </script>
@endsection