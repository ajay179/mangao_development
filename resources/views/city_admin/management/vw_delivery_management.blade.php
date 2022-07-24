@extends('city_admin.layout.layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

   
    <!-- Main content -->
    <section class="content" >
        <div class="row">
            <div class="col-md-6 d-inline-flex p-2" id="form_reedem">
                <section class="content-header">
                    <h1>Delivery Management  </h1>
                </section>

                <div class="box box-primary">
                    <div class="box-body light-green-body mob_min_height_auto">
                          <form method="POST" id="deliveryManagementForm" action="{{ route('delivery.Management.action') }}">
                          @csrf

                          <input type="hidden" name="txtpkey" id="txtpkey" value="{{!empty($delivery_mangement_details[0]->id) ? $delivery_mangement_details[0]->id : ''}}">
                            
                            <div class="col-md-12 form-group no-padd">
                                <label>Base Delivery Charges (Upto 3 KM) <span style="color: red;">*</span></label>
                                <input type="text" name="upto_3_km_charge" id="upto_3_km_charge" autocomplete="off" class="form-control" value="{{!empty($delivery_mangement_details[0]->upto_3_km_charge) ? $delivery_mangement_details[0]->upto_3_km_charge : ''}}">
                               
                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->

                            <div class="col-md-12 form-group no-padd">
                                <label>Per KM Charges after 3 KM <span style="color: red;">*</span></label>
                                <input type="text" name="charge_after_3_km" id="charge_after_3_km" autocomplete="off" class="form-control" value="{{!empty($delivery_mangement_details[0]->charge_after_3_km) ? $delivery_mangement_details[0]->charge_after_3_km : ''}}">
                               

                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->

                             <div class="col-md-12 form-group no-padd">
                                <label>Base Delivery Charges to delivery boy (Upto 3 KM)<span style="color: red;">*</span></label>
                                <input type="text" name="deli_boy_charge_upto_3km" id="deli_boy_charge_upto_3km" autocomplete="off" class="form-control" value="{{!empty($delivery_mangement_details[0]->deli_boy_charge_upto_3km) ? $delivery_mangement_details[0]->deli_boy_charge_upto_3km : ''}}">
                               

                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->

                             <div class="col-md-12 form-group no-padd">
                                <label>Per KM to delivery boy Charges after 3 KM <span style="color: red;">*</span></label>
                                <input type="text" name="deli_boy_charge_after_3km" id="deli_boy_charge_after_3km" autocomplete="off" class="form-control" value="{{!empty($delivery_mangement_details[0]->deli_boy_charge_after_3km) ? $delivery_mangement_details[0]->deli_boy_charge_after_3km : ''}}">
                               

                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->

                            <div class="clearfix"></div>
                            <div class="col-md-12 form-group no-padd">
                                <button type="submit" name="submit_btn" id="submit_btn" class="btn btn-success save_btn submit sub-btn" data-id="submit" ><i class="fa fa-plus"></i> Add</button>
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
    $(".ct_management_active").addClass("active");
    $(".ct_delivery_management_active").addClass("active");
</script>
<script type="text/javascript">
  $("#example").dataTable();

 </script>
@endsection