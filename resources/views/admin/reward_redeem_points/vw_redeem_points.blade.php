@extends('admin.layout.layout')
@section('content')



 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6 d-inline-flex p-2">
                <section class="content-header">
                    <h1>Update Reedem points </h1>
                </section>

                <div class="box box-primary">
                    <div class="box-body light-green-body mob_min_height_auto">
                          <form method="POST" id="cityForm" action="{{ route('city.action') }}">
                          @csrf
                        
                            <div class="col-md-12 form-group no-padd">
                                <label>Reward Points<span style="color: red;">*</span></label>
                                <input type="text" name="reward_points" id="reward_points" autocomplete="off" class="form-control" value="{{!empty($redeem_point_details[0]->reward_points) ? $redeem_point_details[0]->reward_points : ''}}">
                                <input type="hidden" name="txtpkey" id="txtpkey" value="{{!empty($redeem_point_details[0]->id) ? $redeem_point_details[0]->id : ''}}">
                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->

                            <div class="col-md-12 form-group no-padd">
                                <label>value<span style="color: red;">*</span></label>
                                <input type="text" name="value" id="value" autocomplete="off" class="form-control" value="{{!empty($redeem_point_details[0]->value) ? $redeem_point_details[0]->value : ''}}">
                                <input type="hidden" name="txtpkey" id="txtpkey" value="{{!empty($redeem_point_details[0]->id) ? $redeem_point_details[0]->id : ''}}">
                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->

                            <div class="clearfix"></div>
                            <div class="col-md-12 form-group no-padd">
                                <button type="submit" name="submit_btn" id="submit_btn" class="btn btn-success save_btn submit sub-btn" data-id="submit"> Update</button>
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
    $(".reward_redeem_point").addClass("active");
    $(".redeem_point").addClass("active");
</script>
@endsection