@extends('vendor.layout.layout')
@section('content')


 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <section class="content-header">
                    <h1>Add Sub Category </h1>
                </section>

                <div class="box box-primary">
                    <div class="box-body light-green-body mob_min_height_auto">
                          <form method="POST" id="vendorSubCategoryForm" action="{{ route('vendor.sub.category.action') }}">
                          @csrf
                        
                          
                          <div class="col-md-12 form-group no-padd">
                            <label>Select Category<span style="color: red;">*</span></label>
                            @php $vendor_category_id =  !empty($vendor_sub_category_data[0]->vendor_category_id) ? $vendor_sub_category_data[0]->vendor_category_id :  '' @endphp
                            <select class="form-control" name="vendor_category_id" id="vendor_category_id">
                                <option value="">Select Category</option>
                                @if (!empty($get_vendor_category)) 
                                   @foreach ($get_vendor_category as $key => $value)
                                <option value="{{ $value['id'] }}"  @if ($value->id == $vendor_category_id) selected @endif> {{ ucwords($value['vendor_category_name']) }}</option>
                                   @endforeach
                                @endif
                            </select>
                            <input type="hidden" class="form-control" id="txtpkey" name="txtpkey" autocomplete="off" value="{{ !empty($vendor_sub_category_data[0]->id) ? $vendor_sub_category_data[0]->id : '' }}">
                          </div>
                          <div class="clearfix"></div>
                            <div class="col-md-12 form-group no-padd">
                                <label>Sub Category Name<span style="color: red;">*</span></label>
                                <input type="text" name="vendor_sub_category_name" id="vendor_sub_category_name" autocomplete="off" class="form-control" value="{{!empty($vendor_sub_category_data[0]->vendor_sub_category_name) ? $vendor_sub_category_data[0]->vendor_sub_category_name : ''}}">
                               
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

            <div class="col-md-8 ">
                <section class="content-header">
                    <h1>Sub Category List </h1>

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
                                                      <th width="5%">Category Name</th>
                                                      <th width="5%">Sub Category Name</th>
                                                      <th width="2%" >created at</th>
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
    $(".sub_category_active").addClass("active");
</script>

<script type="text/javascript">
  // $(function () {
    let table = $('#example').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('vendor.sub.category.getDataTable') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'vendor_category_name', name: 'vendor_category_name'},
            {data: 'vendor_sub_category_name', name: 'vendor_sub_category_name'},
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