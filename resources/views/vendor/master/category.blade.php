@extends('vendor.layout.layout')
@section('content')


 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <section class="content-header">
                    <h1>Add Category </h1>
                </section>

                <div class="box box-primary">
                    <div class="box-body light-green-body mob_min_height_auto">
                          <form method="POST" id="vendorCategoryForm" enctype='multipart/form-data' action="{{ route('vendor.category.action') }}">
                          @csrf
                        
                          

                            <div class="col-md-12 form-group no-padd">
                                <label>Category Name<span style="color: red;">*</span></label>
                                <input type="text" name="vendor_category_name" id="vendor_category_name" autocomplete="off" class="form-control" maxlength="100" value="{{!empty($vendor_category_data[0]->vendor_category_name) ? $vendor_category_data[0]->vendor_category_name : ''}}">
                                
                                <input type="hidden" class="form-control" id="txtpkey" name="txtpkey" autocomplete="off" value="{{ !empty($vendor_category_data[0]->id) ? $vendor_category_data[0]->id : '' }}">
                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->

                           

                            <div class="col-md-12 form-group no-pad">
                              <div class="upload_img">
                                  <div class="upload_photo">
                                      <label>Image <span style="color: red;">*(png,jpg,jpeg 500 X 300)</span></label>
                                      <input type="file" name="vendor_category_image" accept=".jpg,.jpeg,.bmp,.png," id="vendor_category_image" onchange="change_img('vendor_category_image','fileold')" class="form-control">
                                      <input type="hidden" name="vcategory_image_old" id="vcategory_image_old" value="{{ !empty($vendor_category_data[0]->vendor_category_image) ? $vendor_category_data[0]->vendor_category_image : '' }}" class="form-control">
                                  </div>
                                  <input type="hidden" class="form-control">

                                  <div class="img-preview">
                                      <div class="photo p-relative">
                                          <img id="fileold" name="fileold" src="{{ !empty($vendor_category_data[0]->show_vendor_category_image) ? $vendor_category_data[0]->show_vendor_category_image : asset('commonarea/dist/img/default.png') }} " alt="image" style="height:100px; width:140px; margin-top:5px;object-fit: cover;" class="profile-img4">
                                      </div>
                                  </div>
                                </div>
                            </div>
                            <div class="col-md-12 form-group no-padd">
                                <button type="submit" name="submit_btn" id="submit_btn" class="btn btn-success save_btn submit sub-btn" data-id="submit"><i class="fa fa-plus"></i> Add</button>
                                <a href=""> <button type="button" class="btn btn-danger cancel-btn"><i class="fa fa-times-circle"></i> Cancel</button></a>
                            </div> <!-- End form-group -->
                          </form>
                    </div> <!-- End box-body -->
                </div> <!-- End box -->
            </div>

            <div class="col-md-8 ">
                <section class="content-header">
                    <h1>Categories List </h1>

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
                                                      <th width="5%">Category Name</th>
                                                      <th width="10%">Category Image</th>
                                                      <th width="2%" >created at</th>
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
    $(".category_active").addClass("active");
</script>

<script type="text/javascript">
  // $(function () {
    let table = $('#example').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('vendor.category.getDataTable') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'vendor_category_name', name: 'vendor_category_name'},
            {data: 'vendor_category_image', name: 'vendor_category_image'},
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