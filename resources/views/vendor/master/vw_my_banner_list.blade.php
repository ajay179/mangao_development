@extends('vendor.layout.layout')
@section('content')


 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <section class="content-header">
                    <h1>Add Promotional Banner </h1>
                </section>

                <div class="box box-primary">
                    <div class="box-body light-green-body mob_min_height_auto">
                          <form method="POST" id="vendorbannerForm" enctype='multipart/form-data' action="{{ route('vendor.my.banner.action') }}">
                          @csrf
                    
                            <div class="col-md-12 form-group no-pad">
                              <div class="upload_img">
                                  <div class="upload_photo">
                                      <label>Image <span style="color: red;">*</span></label>
                                      <input type="file" name="vendor_banner_img" accept=".jpg,.jpeg,.bmp,.png," id="vendor_banner_img" onchange="change_img('vendor_banner_img','fileold')" class="form-control">
                                      <input type="hidden" name="vendor_banner_image_old" id="vendor_banner_image_old" value="{{ !empty($vendor_banner_data[0]->vendor_banner_img) ? $vendor_banner_data[0]->vendor_banner_img : '' }}" class="form-control">
                                  </div>
                                  <input type="hidden" class="form-control">

                                  <div class="img-preview">
                                      <div class="photo p-relative">
                                          <img id="fileold" name="fileold" src="{{ !empty($vendor_banner_data[0]->show_admin_img) ? $vendor_banner_data[0]->show_admin_img : asset('commonarea/dist/img/default.png') }} " alt="image" style="height:100px; width:140px; margin-top:5px;object-fit: cover;" class="profile-img4">
                                      </div>
                                  </div>
                                </div>
                            </div>
                            <div class="col-md-12 form-group no-padd">
                               
                                <button type="submit" name="submit_btn" id="submit_btn" class="btn btn-success save_btn submit" data-id="submit" id="blogbtn"><i class="fa fa-check-circle"></i>
                                    {{ !empty($vendor_banner_data[0]->id) ? 'Update' : 'Add' }}</button>
                                <a href=""> <button type="button" class="btn btn-danger cancel-btn"><i class="fa fa-times-circle"></i> Cancel</button></a>
                            </div> <!-- End form-group -->
                          </form>
                    </div> <!-- End box-body -->
                </div> <!-- End box -->
            </div>

            <div class="col-md-8 ">
                <section class="content-header">
                    <h1>Banners List </h1>

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
                                                      <th width="5%" class="text-center">Sr No.</th>
                                                      <th width="15%">Banner Image</th>
                                                      <!-- <th width="15%">Status</th> -->
                                                      <th width="8%" >created at</th>
                                                      <th width="3%" >Action</th>
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
    $(".my_banner_active").addClass("active");

    $(document).ready(function() {

        $('#promotion_date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            changeMonth: true,
            changeYear: true,
            mindate:0,
        });
    });
</script>

<script type="text/javascript">
  
    let table = $('#example').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('vendor.my.banner.getDataTable') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
           
            {data: 'vendor_banner_img', name: 'vendor_banner_img'},
            {data: 'date', name: 'date'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
  

  function reload_table() {
      table.DataTable().ajax.reload(null, false);
   }

 </script>
@endsection