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

                    <h1>{{ !empty($cityadmin_data) ? 'Edit' : 'Add' }} delivery boy
                        <div class="pull-right">
                            <a href="{{ route('city.admin') }}"><button type="button" class="btn btn-danger"><i class="fa fa-arrow-circle-left"></i> Back
                                </button></a>
                        </div>

                    </h1>
                </section>
                <section class="content" style="padding:5px 0px;">
                    <div class="box box-primary">
                        <div class="box-body light-green-body">
                            <form method='POST' id="cityAdminForm" enctype='multipart/form-data' action="{{ route('cityadmin.action')}}" >
                            @csrf  
                           <div class="col-md-8 no-pad-left">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Vendor Category<span style="color: red;">*</span></label>
                                        @php $city_id =  !empty($cityadmin_data[0]->city_id) ? $cityadmin_data[0]->city_id :  '' @endphp
                                        <select class="form-control" name="city_id" id="city_id">
                                            <option value="">Select Ctegory</option>
                                            @if (!empty($city_data)) 
                                               @foreach ($city_data as $key => $value)
        <option value="{{ $value['id'] }}"  @if ($value->id == $city_id) selected @endif> {{ ucwords($value['city_name']) }}</option>
                                               @endforeach
                                            @endif
                                        </select>
                                        <input type="hidden" class="form-control" id="txtpkey" name="txtpkey" autocomplete="off" value="{{ !empty($cityadmin_data[0]->id) ? $cityadmin_data[0]->id : '' }}">
                                    </div>

                                    <div  class="col-md-6 form-group no-pad-left">
                                        <label>Store name<span style="color: red;">*</span></label>
                                         <input type="text" class="form-control" placeholder="Vendor Name" id="admin_name" name="admin_name" autocomplete="off" value="{{ !empty($cityadmin_data[0]->admin_name) ? $cityadmin_data[0]->admin_name : ''}}">

                                    </div>
                                    <div  class="col-md-6 form-group">
                                        <label>Store owner name<span style="color: red;">*</span></label>
                                         <input type="text" class="form-control" placeholder="store.owner name" id="admin_name" name="admin_name" autocomplete="off" value="{{ !empty($cityadmin_data[0]->admin_name) ? $cityadmin_data[0]->admin_name : ''}}">

                                    </div>
                                    <div  class="col-md-6 form-group no-pad-left">
                                        <label>Comission<span style="color: red;">*</span></label>
                                         <input type="text" class="form-control" placeholder="Enter Comission in Percentage" id="admin_name" name="admin_name" autocomplete="off" value="{{ !empty($cityadmin_data[0]->admin_name) ? $cityadmin_data[0]->admin_name : ''}}">

                                    </div>

                                    <div  class="col-md-6 form-group">
                                        <label>Latitude<span style="color: red;">*</span></label>
                                         <input type="text" class="form-control" placeholder="latitude" id="admin_name" name="admin_name" autocomplete="off" value="{{ !empty($cityadmin_data[0]->admin_name) ? $cityadmin_data[0]->admin_name : ''}}">

                                    </div>
                                    <div  class="col-md-6 form-group no-pad-left">
                                        <label>Longitude<span style="color: red;">*</span></label>
                                         <input type="text" class="form-control" id="admin_name" placeholder="longitude" name="admin_name" autocomplete="off" value="{{ !empty($cityadmin_data[0]->admin_name) ? $cityadmin_data[0]->admin_name : ''}}">

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
                                                <input type="hidden" name="admin_image_old" id="admin_image_old" value="{{ !empty($cityadmin_data[0]->admin_img) ? $cityadmin_data[0]->admin_img : '' }}" class="form-control">
                                            </div>
                                            <input type="hidden" class="form-control">

                                            <div class="img-preview">
                                                <div class="photo p-relative">
                                                    <img id="fileold" name="fileold" src="{{ !empty($cityadmin_data[0]->show_admin_img) ? $cityadmin_data[0]->show_admin_img : asset('commonarea/dist/img/default.png') }} " alt="image" style="height:100px; width:140px; margin-top:5px;object-fit: cover;" class="profile-img4">
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            
                            <div class="col-md-12 form-group no-pad-left ">
                                <label>Address <span style="color: red;">*</span></label>
                                <textarea class="form-control" placeholder="address" name="address" autocomplete="off">{{ !empty($cityadmin_data[0]->address) ? $cityadmin_data[0]->address : ''}}</textarea>
                            </div>


                            <div class="clearfix"></div>

                            <div class="col-md-12 form-group no-pad-left ">
                                <label>messages.delivery range <span style="color: red;">*</span></label>
                               <input type="text" class="form-control" id="admin_email" name="admin_email" autocomplete="off" value="{{ !empty($cityadmin_data[0]->admin_email) ? $cityadmin_data[0]->admin_email : '' }}" placeholder="messages.how many kilometer you have to delivered">
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-md-12 no-pad-left">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Email<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="admin_email" placeholder="Vendor Email" name="admin_email" autocomplete="off" value="{{ !empty($cityadmin_data[0]->admin_email) ? $cityadmin_data[0]->admin_email : '' }}">
                                    </div>

                                    <div  class="col-md-6 form-group no-pad-left">
                                        <label>Phone<span style="color: red;">*</span></label>
                                         <input type="text" class="form-control" id="admin_mobile" placeholder="Vendor Mobile" name="admin_mobile" autocomplete="off" value="{{ !empty($cityadmin_data[0]->admin_mobile) ? $cityadmin_data[0]->admin_mobile : ''}}">

                                    </div>
                                    
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-md-12 no-pad-left">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Password<span style="color: red;">*</span></label>
                                        <input type="password" class="form-control" placeholder="password" id="password" name="password" autocomplete="off" value="{{ !empty($cityadmin_data[0]->encrypt_password) ? $cityadmin_data[0]->encrypt_password : ''}}">
                                    </div>

                                    <div  class="col-md-6 form-group no-pad-left">
                                        <label>Confirm Password<span style="color: red;">*</span></label>
                                         <input type="password" class="form-control" placeholder="confirm password" id="confirm_password" name="confirm_password" autocomplete="off" value="{{ !empty($cityadmin_data[0]->encrypt_password) ? $cityadmin_data[0]->encrypt_password : ''}}">

                                    </div>
                                    
                                </div>
                            </div>


                            <div class="col-md-12 form-group no-padd">

                                <button type="submit" class="btn btn-success save_btn submit" data-id="submit" id="blogbtn"><i class="fa fa-check-circle"></i>
                                    {{ !empty($cityadmin_data[0]->id) ? 'Update' : 'Submit' }}</button>

                                <a href="{{ route('city.add.admin')}}"> <button type="button" class="btn btn-danger"><i class="fa fa-times-circle"></i> Clear</button></a>
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
    $(".ct_delivery_boy_list_active").addClass("active");

    function change_img(img, preview_img) {
       var oFReader = new FileReader();
       oFReader.readAsDataURL($('#' + img)[0].files[0]);
   
       oFReader.onload = function(oFREvent) {
           $('#' + preview_img).attr('src', oFREvent.target.result);
       }
   }

</script>

@endsection