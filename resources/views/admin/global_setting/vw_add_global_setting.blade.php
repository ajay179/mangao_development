@extends('admin.layout.layout')
@section('content')


 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <section class="content-header">
                    <h1><i class="fa fa-user-o"></i>  Account Settings </h1>
                    <p>View and update your Account settings.</p>
                </section>

                <div class="box box-primary">
                    <div class="box-body light-green-body mob_min_height_auto">
                          <form method="POST" id="categoryForm" enctype='multipart/form-data' action="{{ route('category.action') }}">
                          @csrf
                        
                            <div class="col-md-12 form-group no-padd">
                                <label>Admin Name<span style="color: red;">*</span></label>
                                <input type="text" name="category_name" id="category_name" autocomplete="off" class="form-control" value="{{!empty($category_data[0]->category_name) ? $category_data[0]->category_name : ''}}">
                               
                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->
                            <div class="clearfix"></div>

                            <div class="col-md-12 form-group no-padd">
                                <label>Admin Email<span style="color: red;">*</span></label>
                                <input type="text" name="category_position" id="category_position" autocomplete="off" class="form-control" value="{{!empty($category_data[0]->category_position) ? $category_data[0]->category_position : ''}}">
                               
                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->
                            <div class="clearfix"></div>

                            <div class="col-md-12 form-group no-padd">
                                <label>Admin Email<span style="color: red;">*</span></label>
                                <input type="text" name="category_position" id="category_position" autocomplete="off" class="form-control" value="{{!empty($category_data[0]->category_position) ? $category_data[0]->category_position : ''}}">
                               
                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->
                            <div class="clearfix"></div>
                            

                            <div class="col-md-12 form-group no-pad">
                              <div class="upload_img">
                                  <div class="upload_photo">
                                      <label>Admin Image <span style="color: red;">*</span></label>
                                      <input type="file" name="category_image" accept=".jpg,.jpeg,.bmp,.png," id="category_image" onchange="change_img('category_image','fileold')" class="form-control">
                                      <input type="hidden" name="admin_image_old" id="admin_image_old" value="{{ !empty($category_data[0]->category_image) ? $category_data[0]->category_image : '' }}" class="form-control">
                                  </div>
                                  <input type="hidden" class="form-control">

                                  <div class="img-preview">
                                      <div class="photo p-relative">
                                          <img id="fileold" name="fileold" src="{{ !empty($category_data[0]->show_category_img) ? $category_data[0]->show_category_img : asset('commonarea/dist/img/default.png') }} " alt="image" style="height:100px; width:140px; margin-top:5px;object-fit: cover;" class="profile-img4">
                                      </div>
                                  </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>


                            <div class="col-md-12 form-group no-padd">
                                <label>password<span style="color: red;">*</span></label>
                                <input type="text" name="category_position" id="category_position" autocomplete="off" class="form-control" value="{{!empty($category_data[0]->category_position) ? $category_data[0]->category_position : ''}}">
                               
                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->
                            <div class="clearfix"></div>
                            

                            <div class="col-md-12 form-group no-padd">
                                <label>Retype Password<span style="color: red;">*</span></label>
                                <input type="text" name="category_position" id="category_position" autocomplete="off" class="form-control" value="{{!empty($category_data[0]->category_position) ? $category_data[0]->category_position : ''}}">
                               
                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->
                            <div class="clearfix"></div>
                            


                            <div class="col-md-12 form-group no-padd">
                                <button type="submit" name="submit_btn" id="submit_btn" class="btn btn-success save_btn submit sub-btn" data-id="submit"><i class="fa fa-plus"></i> Add</button>
                                <a href=""> <button type="button" class="btn btn-danger cancel-btn"><i class="fa fa-times-circle"></i> Cancel</button></a>
                            </div> <!-- End form-group -->
                          </form>
                    </div> <!-- End box-body -->
                </div> <!-- End box -->
            </div>



            <div class="col-md-6">
                <section class="content-header">
                    <h1><i class="fa fa-bell-o"></i>  FCM server Key </h1>
                    <p>FCM server key for notifications.</p>
                </section>

                <div class="box box-primary">
                    <div class="box-body light-green-body mob_min_height_auto">
                          <form method="POST" id="categoryForm" enctype='multipart/form-data' action="{{ route('category.action') }}">
                          @csrf
                        
                          
                            <div class="clearfix"></div>

                            <div class="col-md-12 form-group no-padd">
                                <label>User FCM Server Key*<span style="color: red;">*</span></label>
                                <input type="text" name="category_name" id="category_name" autocomplete="off" class="form-control" value="{{!empty($category_data[0]->category_name) ? $category_data[0]->category_name : ''}}">
                               
                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->
                            <div class="clearfix"></div>

                            <div class="col-md-12 form-group no-padd">
                                <label>Vendor FCM Server Key*<span style="color: red;">*</span></label>
                                <input type="text" name="category_position" id="category_position" autocomplete="off" class="form-control" value="{{!empty($category_data[0]->category_position) ? $category_data[0]->category_position : ''}}">
                               
                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->
                            <div class="clearfix"></div>
                            
                            <div class="col-md-12 form-group no-padd">
                                <label>Delivery Boy FCM Server Key*<span style="color: red;">*</span></label>
                                <input type="text" name="category_position" id="category_position" autocomplete="off" class="form-control" value="{{!empty($category_data[0]->category_position) ? $category_data[0]->category_position : ''}}">
                               
                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->
                            <div class="clearfix"></div>
                            
                            <div class="col-md-12 form-group no-padd">
                                <button type="submit" name="submit_btn" id="submit_btn" class="btn btn-success save_btn submit sub-btn" data-id="submit"><i class="fa fa-plus"></i> Add</button>
                                <a href=""> <button type="button" class="btn btn-danger cancel-btn"><i class="fa fa-times-circle"></i> Cancel</button></a>
                            </div> <!-- End form-group -->
                          </form>
                    </div> <!-- End box-body -->
                </div> <!-- End box -->
            </div>



            
        </div>
    </section>
</div>
<!-- /.row -->
@endsection


@section('js_section')
<script type="text/javascript">
    $(".s_meun").removeClass("active");
    $(".global_setting_section").addClass("active");
</script>

@endsection