@extends('admin.layout.layout')
@section('content')


 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <section class="content-header">
                    <h1>About Us </h1>
                </section>

                <div class="box box-primary">
                    <div class="box-body light-green-body mob_min_height_auto">
                          <form method="POST" id="aboutForm" action="{{ route('cms.action')}}" >
                          @csrf
                        
                            <div class="col-md-12 form-group no-padd">
                                <label>Title<span style="color: red;">*</span></label>
                                <input type="text" name="title_name" id="title_name" autocomplete="off" class="form-control" value="About Us" readonly>
                                <input type="hidden" name="txtpkey" id="txtpkey" value="{{!empty($about_data[0]->id) ? $about_data[0]->id : ''}}">
                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->
                            <div class="clearfix"></div>

                            <div class="col-md-12 form-group no-padd">
                                <label> About Content<span style="color: red;">*</span></label>
                                <textarea  name="content_details" rows="6" id="content_details" autocomplete="off" class="form-control" value="{{!empty($about_data[0]->content_details) ? $about_data[0]->content_details : ''}}"> {{!empty($about_data[0]->content_details) ? $about_data[0]->content_details : ''}}</textarea>
                               
                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->




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
                    <h1>About Us </h1>

                </section>
                <div class="box box-primary">
                    
                        <div class="box-body">

                            <div class="">

                                <div class="row">
                                    <div class="col-sm-12">
                                       <h3> Contant Details :   </h3>
                                       <p>{{!empty($about_data[0]->content_details) ? $about_data[0]->content_details : ''}}   </p>
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
    $(".content_active").addClass("active");
    $(".about_us_active").addClass("active");

</script>

@endsection




