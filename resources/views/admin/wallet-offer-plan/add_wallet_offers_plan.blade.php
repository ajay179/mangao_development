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
                <section class="content" >
                    <div class="box box-primary">
                        <div class="box-body light-green-body">
                            <form method='POST' id="offerPlanForm" enctype='multipart/form-data' action="{{ route('offerplan.action')}}" >
                            @csrf  
                            
                            <div class="col-md-8 no-pad-left">
                                <div class="row">

                                    <div class="col-md-12 form-group">
                                        <label>Amount<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="offer_amount" name="offer_amount" autocomplete="off" value="{{ !empty($offer_plan_data[0]->offer_amount) ? $offer_plan_data[0]->offer_amount : ''}}">

                                        <input type="hidden" name="txtpkey" value="{{ !empty($offer_plan_data[0]->edit_id) ? $offer_plan_data[0]->edit_id : ''}}" >
                                        
                                    </div>

                                    <div  class="col-md-6 form- ">
                                        <label>Discount Value<span style="color: red;">*</span></label>
                                        @php $discount_value_type =  !empty($offer_plan_data[0]->discount_value_type) ? $offer_plan_data[0]->discount_value_type :  '' @endphp
                                         <select class="form-control" name="discount_value_type" id="discount_value_type">
                                            <option value="">-- Select --</option>
                                            <option value="percentage"  @if ($discount_value_type == "percentage") selected @endif >messages.Precentage</option>
                                            <option value="price"  @if ($discount_value_type == "price") selected @endif>Price</option>
                                        </select>
                                    </div>

                                    <div  class="col-md-6 form-group">
                                        <label>Amount<span style="color: red;">*</span></label>
                                         <input type="text" class="form-control" id="discount_amount" name="discount_amount" autocomplete="off" value="{{ !empty($offer_plan_data[0]->discount_amount) ? $offer_plan_data[0]->discount_amount : ''}}">

                                    </div>
                                    
                                    <div class="col-md-12 form-group ">
                                        <label>Maximum Offer <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="maximum_offer" name="maximum_offer" autocomplete="off" value="{{ !empty($offer_plan_data[0]->maximum_offer) ? $offer_plan_data[0]->maximum_offer : ''}}">
                                    </div>


                                    
                               
                                </div>
                            </div>

                            

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12 form-group no-pad">
                                        <div class="upload_img">
                                            <div class="upload_photo">
                                                <label>Image <small class="text-danger">(size:730*350)</small><span style="color: red;">*</span></label>
                                                <input type="file" name="offer_plan_image" accept=".jpg,.jpeg,.bmp,.png," id="offer_plan_image" onchange="change_img('offer_plan_image','offer_old_img')" class="form-control">
                                                <input type="hidden" name="offer_image_old" id="offer_image_old" value="{{ !empty($offer_plan_data[0]->offer_plan_image) ? $offer_plan_data[0]->offer_plan_image : '' }}" class="form-control">
                                            </div>
                                            <input type="hidden" class="form-control">

                                            <div class="img-preview">
                                                <div class="photo p-relative">
                                                    <img id="offer_old_img" name="offer_old_img" src="{{ !empty($offer_plan_data[0]->show_offer_img) ? $offer_plan_data[0]->show_offer_img : asset('commonarea/dist/img/default.png') }} " alt="image" style="height:100px; width:140px; margin-top:5px;object-fit: cover;" class="profile-img4">
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            
                            <div class="clearfix"></div>

                            <div class="col-md-12 form-group no-padd">
                                <button type="submit" id="submit_btn" class="btn btn-success save_btn submit sub-btn" data-id="submit"><i class="fa fa-plus"></i> Add</button>
                                <a href=""> <button type="button" class="btn btn-danger cancel-btn"><i class="fa fa-times-circle"></i> Cancel</button></a>
                            </div> <!-- End form-group -->
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
    $(".wallet_normal_admin").addClass("active");
    $(".offer_plan_active").addClass("active");
    
</script>

@endsection

