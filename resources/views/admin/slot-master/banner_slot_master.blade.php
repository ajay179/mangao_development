@extends('admin.layout.layout')
@section('content')

<style type="text/css">
    
.priority-amount-div{
  display: none;
}

</style>
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <section class="content-header">
                    <h1>Add Banner Time Slot </h1>
                </section>

                <div class="box box-primary">
                    <div class="box-body light-green-body mob_min_height_auto">
                          <form method="POST" id="categoryForm" enctype='multipart/form-data' action="{{ route('time.slot.master.action') }}">
                          @csrf
                        
                         

                            <div class="col-md-12 form-group no-padd">
                                <label>Slot Name<span style="color: red;">*</span></label>
                                <input type="text" name="slot_name" id="slot_name" autocomplete="off" class="form-control" value="{{!empty($category_data[0]->slot_name) ? $category_data[0]->slot_name : ''}}">
                                
                                <input type="hidden" name="slot_category" id="slot_category" autocomplete="off" class="form-control" value="{{!empty($category_data[0]->slot_category) ? $category_data[0]->slot_category : $slot_category }}">

                                <input type="hidden" name="txtpkey" id="txtpkey" autocomplete="off" class="form-control" value="{{!empty($category_data[0]->id) ? $category_data[0]->id : '' }}">

                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->

                            <div class="clearfix"></div>
                            <div>
                                <div class="col-md-6 form-group no-padd">
                                    <label>From Time<span style="color: red;">*</span></label>
                                    <input type="text" name="from_time" id="from_time" autocomplete="off" class="form-control" value="{{!empty($category_data[0]->from_time) ? $category_data[0]->from_time : ''}}">
                                   
                                    <div class="text-danger" id="name_error"></div>
                                </div> <!-- End form-group -->
                                
                                <div class="col-md-6 form-group">
                                    <label>To Time<span style="color: red;">*</span></label>
                                    <input type="text" name="to_time" id="to_time" autocomplete="off" class="form-control" value="{{!empty($category_data[0]->to_time) ? $category_data[0]->to_time : ''}}">
                                   
                                    <div class="text-danger" id="name_error"></div>
                                </div> <!-- End form-group -->
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12 form-group no-padd">
                                <label>Max. No. Of Banner<span style="color: red;">*</span></label>
                                
                                 <select class="form-control" name="max_no_of_banners" id="max_no_of_banners">
                                        <option value="">Select Number</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                       
                                    </select>
                                <div class="text-danger" id="name_error"></div>
                            </div> <!-- End form-group -->

                            <div class="clearfix"></div>

                            <div class="col-md-12 form-group priority-amount-div no-padd" id="banner_prize_div_1">
                                <label>1 Banner priority amount<span style="color: red;">*</span></label>
                                <input type="text" name="banners_1_amount" id="banners_1_amount" autocomplete="off" class="form-control"  oninput="this.value=this.value.replace(/[^0-9 ]/g,'');" value="{{!empty($category_data[0]->banners_1_amount) ? $category_data[0]->banners_1_amount : ''}}">
                            
                                <div class="text-danger" id="banners_1_amount_error"></div>
                            </div> <!-- End form-group -->

                            <div class="clearfix"></div>

                            <div class="col-md-12 form-group priority-amount-div no-padd" id="banner_prize_div_2">
                                <label>2 Banner priority amount<span style="color: red;">*</span></label>
                                <input type="text" name="banners_2_amount" id="banners_2_amount" autocomplete="off" class="form-control"  oninput="this.value=this.value.replace(/[^0-9 ]/g,'');" value="{{!empty($category_data[0]->banners_2_amount) ? $category_data[0]->banners_2_amount : ''}}">
                            
                                <div class="text-danger" id="banners_2_amount_error"></div>
                            </div> <!-- End form-group -->

                            <div class="clearfix"></div>

                            <div class="col-md-12 form-group priority-amount-div no-padd" id="banner_prize_div_3">
                                <label>3 Banner priority amount<span style="color: red;">*</span></label>
                                <input type="text" name="banners_3_amount" id="banners_3_amount" autocomplete="off" class="form-control"  oninput="this.value=this.value.replace(/[^0-9 ]/g,'');" value="{{!empty($category_data[0]->banners_3_amount) ? $category_data[0]->banners_3_amount : ''}}">
                            
                                <div class="text-danger" id="banners_3_amount_error"></div>
                            </div> <!-- End form-group -->

                            <div class="clearfix"></div>

                            <div class="col-md-12 form-group priority-amount-div no-padd" id="banner_prize_div_4">
                                <label>4 Banner priority amount<span style="color: red;">*</span></label>
                                <input type="text" name="banners_4_amount" id="banners_4_amount" autocomplete="off" class="form-control"  oninput="this.value=this.value.replace(/[^0-9 ]/g,'');" value="{{!empty($category_data[0]->banners_4_amount) ? $category_data[0]->banners_4_amount : ''}}">
                            
                                <div class="text-danger" id="banners_1_amount_error"></div>
                            </div> <!-- End form-group -->

                            <div class="clearfix"></div>

                            <div class="col-md-12 form-group priority-amount-div no-padd" id="banner_prize_div_5">
                                <label>5 Banner priority amount<span style="color: red;">*</span></label>
                                <input type="text" name="banners_5_amount" id="banners_5_amount" autocomplete="off" class="form-control"  oninput="this.value=this.value.replace(/[^0-9 ]/g,'');" value="{{!empty($category_data[0]->banners_5_amount) ? $category_data[0]->banners_5_amount : ''}}">
                            
                                <div class="text-danger" id="banners_5_amount_error"></div>
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

            <div class="col-md-8 ">
                <section class="content-header">
                    <h1>Banner Slot List </h1>

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
                                                      <th width="5%">Slot Name</th>
                                                      <th width="5%">From Time</th>
                                                      <th width="5%">To Time</th>
                                                      <th width="5%">Status</th>
                                                      <th width="5%">Created At</th>
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
    $(".slot_master_section").addClass("active");
    $(".bannet_slot_master_active").addClass("active");

     $(document).ready(function() {

        $('#from_time').timepicker();
        $('#to_time').timepicker();
    });
</script>

<script type="text/javascript">
  // $(function () {
    let table = $('#example').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('master.time.slot.getDataTable','banner_promotion') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'slot_name', name: 'slot_name'},
            {data: 'from_time', name: 'from_time'},
            {data: 'to_time', name: 'to_time'},
            {data: 'status', name: 'status'},
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