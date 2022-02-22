@extends('admin.layout.layout')
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

                    <h1> Offer Plan
                        <div class="pull-right">
                            <a href="{{ route('offer.plan.page') }}"><button type="button" class="btn btn-danger"><i class="fa fa-arrow-circle-left"></i> Back
                                </button></a>
                        </div>

                    </h1>
                </section>
                <section class="content" style="padding:5px 0px;">
                    <div class="box box-primary">
                        <div class="box-body light-green-body">
                            <form method='POST' id="offerPlanForm" enctype='multipart/form-data' action="{{ route('offerplan.action')}}" >
                            @csrf  
                           <div class="col-md-8 " style="padding-left:50px;">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                       
                                        <input type="hidden" class="form-control" id="txtpkey" name="txtpkey" autocomplete="off" value="">
                                    </div>

                                    <div  class="col-md-12 form-group ">
                                        <label> Amount<span style="color: red;">*</span></label>
                                         <input type="text" class="form-control" id="admin_name" name="admin_name" autocomplete="off" value="">

                                    </div>
                                    
                                    <div class="col-md-12 form-group ">
                                        <label>Discount Value <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="admin_name" name="admin_name" autocomplete="off" value=""><br>
                                    </div>

                                    <div class="col-md-12 form-group ">
                                        <input type="text" class="form-control" id="admin_name" name="admin_name" autocomplete="off" value="">
                                    </div>


                                    <div class="col-md-12 form-group">
                                        <label>Maximum Offer<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="commision" name="commision" autocomplete="off" value="">
                                        
                                    </div>
                               
                               
                                    <div class="col-md-12 form-group ">
                                        <div class="upload_img">
                                            <div class="upload_photo">
                                                <label>Image <small class="text-danger">(size:730*350)</small><span style="color: red;">*</span></label>
                                                <input type="file" name="admin_image" accept=".jpg,.jpeg,.bmp,.png," id="admin_image" onchange="change_img('admin_image','fileold')" class="form-control">
                                                <input type="hidden" name="admin_image_old" id="admin_image_old" value="" class="form-control">
                                            </div>
                                            <input type="hidden" class="form-control">

                                            <div class="img-preview">
                                                <div class="photo p-relative">
                                                    <img id="fileold" name="fileold" src=" " alt="image" style="height:100px; width:140px; margin-top:5px;object-fit: cover;" class="profile-img4">
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            
                            <div class="clearfix"></div>

                           
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
    $(".s_meun").removeClass("active");
    $(".city_cityadmin").addClass("active");
    $(".city_admin_menu").addClass("active");

    function change_img(img, preview_img) {
       var oFReader = new FileReader();
       oFReader.readAsDataURL($('#' + img)[0].files[0]);
   
       oFReader.onload = function(oFREvent) {
           $('#' + preview_img).attr('src', oFREvent.target.result);
       }
   }

</script>

@endsection