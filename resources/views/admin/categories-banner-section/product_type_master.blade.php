@extends('admin.layout.layout')
@section('content')


 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <section class="content-header">
                    <h1>Add Product Type </h1>
                </section>

                <div class="box box-primary">
                    <div class="box-body light-green-body mob_min_height_auto">
                          <form method="POST" id="productTypeMasterForm" action="{{ route('product.type.master.action') }}">
                          @csrf
                        
                           <div class="col-md-12 form-group no-padd">
                                <label>Category<span style="color: red;">*</span></label>
                                @php $product_category_id =  !empty($product_type_master_details[0]->product_category_id) ? $product_type_master_details[0]->product_category_id :  '' @endphp
                                <select class="form-control" name="product_category_id" id="product_category_id">
                                    <option value="">Select Category</option>
                                    @if (!empty($vendor_data)) 
                                       @foreach ($vendor_data as $key => $value)
                                            <option value="{{ $value['id'] }}"  @if ($value->id == $product_category_id) selected @endif> {{ ucwords($value['category_name']) }}</option>
                                       @endforeach
                                    @endif
                                </select>
                                <input type="hidden" class="form-control" id="txtpkey" name="txtpkey" autocomplete="off" value="{{ !empty($product_type_master_details[0]->id) ? $product_type_master_details[0]->id : '' }}">
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-md-12 form-group no-padd">
                                <label>Product type Name<span style="color: red;">*</span></label>
                                <input type="text" name="product_type_name" id="product_type_name" autocomplete="off" class="form-control" value="{{!empty($product_type_master_details[0]->product_type_name) ? $product_type_master_details[0]->product_type_name : ''}}">
                               
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
                    <h1>Product Type List </h1>

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
                                                      <th width="5%">Product Type Name</th>
                                                      <th width="5%">Status</th>
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
    $(".categories_banner_section").addClass("active");
    $(".categories_active").addClass("active");
</script>

<script type="text/javascript">
  // $(function () {
    let table = $('#example').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('product.type.getDataTable') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'category_name', name: 'category_name'},
            {data: 'product_type_name', name: 'product_type_name'},
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