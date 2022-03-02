@extends('city_admin.layout.layout')
@section('content')

<style>
    .ms-parent.form-control {
        padding: 0px;
        width: 100% !important;
    }

    .ms-choice {
        height: 30px !important;
        border: 1px solid #dfe0e6 !important;
        border-radius: 1px;
    }

    .ms-drop.bottom label span {
        padding-left: 10px;
        color: #495057;
        font-weight: 400;
        font-size: 14px;
    }
</style>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row no-margin">
            <div class="col-md-12 no-pad">
                <section class="content-header">

                    <h1>{{ !empty($vendor_info) ? 'Edit' : 'Add' }} Vendore
                        <div class="pull-right">
                            <a href="{{ route('cityadmin.view.vendor.list') }}"><button type="button" class="btn btn-danger"><i class="fa fa-arrow-circle-left"></i> Back
                                </button></a>
                        </div>

                    </h1>
                </section>
                <section class="content" style="padding:5px 0px;">
                    <div class="box box-primary">
                        <div class="box-body light-green-body">
                            <form method='POST' id="vendorForm" enctype='multipart/form-data' action="{{ route('cityadmin.vendor.action')}}" >
                            @csrf  
                           <div class="col-md-8 no-pad-left">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Vendor Category<span style="color: red;">*</span></label>
                                        @php $category_id =  !empty($vendor_info[0]->category_id) ? $vendor_info[0]->category_id :  '' @endphp
                                        <select class="form-control" name="category_id" id="category_id">
                                            <option value="">Select Ctegory</option>
                                            @if (!empty($vendor_data)) 
                                               @foreach ($vendor_data as $key => $value)
                                            <option value="{{ $value['id'] }}"  @if ($value->id == $category_id) selected @endif> {{ ucwords($value['category_name']) }}</option>
                                               @endforeach
                                            @endif
                                        </select>
                                        <input type="hidden" class="form-control" id="txtpkey" name="txtpkey" autocomplete="off" value="{{ !empty($vendor_info[0]->id) ? $vendor_info[0]->id : '' }}">
                                    </div>

                                    <div  class="col-md-6 form-group no-pad-left">
                                        <label>Store name<span style="color: red;">*</span></label>
                                         <input type="text" class="form-control" placeholder="Store Name" id="store_name" name="store_name" autocomplete="off" value="{{ !empty($vendor_info[0]->store_name) ? $vendor_info[0]->store_name : ''}}">

                                    </div>
                                    <div  class="col-md-6 form-group">
                                        <label>Store owner name<span style="color: red;">*</span></label>
                                         <input type="text" class="form-control" placeholder="store.owner name" id="store_owner_name" name="store_owner_name" autocomplete="off" value="{{ !empty($vendor_info[0]->store_owner_name) ? $vendor_info[0]->store_owner_name : ''}}">

                                    </div>
                                    <div  class="col-md-6 form-group no-pad-left">
                                        <label>Comission<span style="color: red;">*</span></label>
                                         <input type="text" class="form-control" placeholder="Enter Comission in Percentage" id="vendor_comission" name="vendor_comission" autocomplete="off" value="{{ !empty($vendor_info[0]->vendor_comission) ? $vendor_info[0]->vendor_comission : ''}}">

                                    </div>

                                    <div  class="col-md-6 form-group">
                                        <label>Latitude<span style="color: red;">*</span></label>
                                         <input type="text" class="form-control" placeholder="latitude" id="vendor_latitude" name="vendor_latitude" autocomplete="off" value="{{ !empty($vendor_info[0]->vendor_latitude) ? $vendor_info[0]->vendor_latitude : ''}}">

                                    </div>
                                    <div  class="col-md-6 form-group no-pad-left">
                                        <label>Longitude<span style="color: red;">*</span></label>
                                         <input type="text" class="form-control" id="vendor_longitude" placeholder="longitude" name="vendor_longitude" autocomplete="off" value="{{ !empty($vendor_info[0]->vendor_longitude) ? $vendor_info[0]->vendor_longitude : ''}}">

                                    </div>
                                    
                                </div>
                            </div>

                            

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12 form-group no-pad">
                                        <div class="upload_img">
                                            <div class="upload_photo">
                                                <label>Image <small class="text-danger">(size:730*350)</small><span style="color: red;">*</span></label>
                                                <input type="file" name="admin_image" accept=".jpg,.jpeg,.bmp,.png," id="admin_image" onchange="change_img('admin_image','fileold')" class="form-control">
                                                <input type="hidden" name="admin_image_old" id="admin_image_old" value="{{ !empty($vendor_info[0]->admin_img) ? $vendor_info[0]->admin_img : '' }}" class="form-control">
                                            </div>
                                            <input type="hidden" class="form-control">

                                            <div class="img-preview">
                                                <div class="photo p-relative">
                                                    <img id="fileold" name="fileold" src="{{ !empty($vendor_info[0]->show_admin_img) ? $vendor_info[0]->show_admin_img : asset('commonarea/dist/img/default.png') }} " alt="image" style="height:100px; width:140px; margin-top:5px;object-fit: cover;" class="profile-img4">
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            
                            <div class="col-md-12 form-group no-pad-left ">
                                <label>Address <span style="color: red;">*</span></label>
                                <textarea class="form-control" placeholder="vendor_address" name="vendor_address" autocomplete="off">{{ !empty($vendor_info[0]->vendor_address) ? $vendor_info[0]->vendor_address : ''}}</textarea>
                            </div>


                            <div class="clearfix"></div>

                            <div class="col-md-12 form-group no-pad-left ">
                                <label>messages.delivery range <span style="color: red;">*</span></label>
                               <input type="text" class="form-control" id="delivery_range" name="delivery_range" autocomplete="off" value="{{ !empty($vendor_info[0]->delivery_range) ? $vendor_info[0]->delivery_range : '' }}" placeholder="messages.how many kilometer you have to delivered">
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-md-12 no-pad-left">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Email<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="vendor_email" placeholder="Vendor Email" name="vendor_email" autocomplete="off" value="{{ !empty($vendor_info[0]->vendor_email) ? $vendor_info[0]->vendor_email : '' }}">
                                    </div>

                                    <div  class="col-md-6 form-group no-pad-left">
                                        <label>Phone<span style="color: red;">*</span></label>
                                         <input type="text" class="form-control" id="vendor_mobile_no" placeholder="Vendor Mobile" name="vendor_mobile_no" autocomplete="off" value="{{ !empty($vendor_info[0]->vendor_mobile_no) ? $vendor_info[0]->vendor_mobile_no : ''}}">

                                    </div>
                                    
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-md-12 no-pad-left">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Password<span style="color: red;">*</span></label>
                                        <input type="password" class="form-control" placeholder="vendor_password" id="vendor_password" name="vendor_password" autocomplete="off" value="{{ !empty($vendor_info[0]->encrypt_password) ? $vendor_info[0]->encrypt_password : ''}}">
                                    </div>

                                    <div  class="col-md-6 form-group no-pad-left">
                                        <label>Confirm Password<span style="color: red;">*</span></label>
                                         <input type="password" class="form-control" placeholder="confirm password" id="confirm_password" name="confirm_password" autocomplete="off" value="{{ !empty($vendor_info[0]->encrypt_password) ? $vendor_info[0]->encrypt_password : ''}}">

                                    </div>
                                    
                                </div>
                            </div>


                            <div class="col-md-12 form-group no-padd">

                                <button type="submit" class="btn btn-success save_btn submit" data-id="submit" id="blogbtn"><i class="fa fa-check-circle"></i>
                                    {{ !empty($vendor_info[0]->id) ? 'Update' : 'Submit' }}</button>

                                <a href="{{ route('cityadmin.add.vendor')}}"> <button type="button" class="btn btn-danger"><i class="fa fa-times-circle"></i> Clear</button></a>
                            </div>
                             </form>
                        </div>
                    </div>
                    <!-- End box-body -->
            </div>
            <!-- End box -->
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

    function change_img(img, preview_img) {
       var oFReader = new FileReader();
       oFReader.readAsDataURL($('#' + img)[0].files[0]);
   
       oFReader.onload = function(oFREvent) {
           $('#' + preview_img).attr('src', oFREvent.target.result);
       }
   }

</script>

@endsection