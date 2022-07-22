@extends('admin.layout.layout')
@section('content')



 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <style type="text/css">
        #form_reedem {
            left      : 57%;
            top       : 30%;
            position  : absolute;
            transform : translate(-50%, -50%);
        }
    </style>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6 d-inline-flex p-2" id="form_reedem">
                <section class="content-header">
                    <h1>App Refer</h1>
                </section>

                <div class="box box-primary">
                    <div class="box-body light-green-body mob_min_height_auto">
                          <form method="POST" id="reedemForm" action="{{ route('app.refer.points.action') }}">
                          @csrf
                            <div class="col-md-12 form-group no-padd">
                                <label>Welcome Coins<span style="color: red;">*</span></label>
                                <input type="text" name="welcome_coins" id="welcome_coins" autocomplete="off" class="form-control" value="{{!empty($app_refer_details[0]->welcome_coins) ? $app_refer_details[0]->welcome_coins : ''}}">
                                <input type="hidden" name="txtpkey" id="txtpkey" value="{{!empty($app_refer_details[0]->id) ? $app_refer_details[0]->id : ''}}">
                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->

                            <div class="col-md-12 form-group no-padd">
                                <label>Text<span style="color: red;">*</span></label>
                                <textarea name="welcome_coins_text" id="welcome_coins_text" autocomplete="off" class="form-control" >{{!empty($app_refer_details[0]->welcome_coins_text) ? $app_refer_details[0]->welcome_coins_text : ''}}</textarea>
                                <input type="hidden" name="txtpkey" id="txtpkey" value="{{!empty($app_refer_details[0]->id) ? $app_refer_details[0]->id : ''}}">
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
    $(".reward_redeem_point").addClass("active");
    $(".app_refer_point").addClass("active");
</script>
@endsection