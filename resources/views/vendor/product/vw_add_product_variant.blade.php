@extends('vendor.layout.layout')
@section('content')


 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <section class="content-header">
                    <h1>Add Product Variant  </h1>
                </section>

                <div class="box box-primary">
                    <div class="box-body light-green-body mob_min_height_auto">
                          <form method="POST" id="vendorProductVariantForm" action="{{ route('vendor.add.product.variant.action') }}">
                          @csrf
                        
                            <div  class="col-md-12 form-group no-padd">
                                <label>Price<span style="color: red;">*</span></label>
                                 <input type="text" class="form-control" placeholder="Price" id="variant_price" name="variant_price" autocomplete="off" value="{{ !empty($product_single_variant_data_for_update[0]->variant_price) ? $product_single_variant_data_for_update[0]->variant_price : ''}}">

                                 <input type="hidden"  id="product_encrypt_id" name="product_encrypt_id" autocomplete="off" value="{{ !empty($product_data[0]->id) ? $product_data[0]->id : ''}}">

                                 <input type="hidden"  id="txtpkey" name="txtpkey" autocomplete="off" value="{{ !empty($product_single_variant_data_for_update[0]->encrypt_id) ? $product_single_variant_data_for_update[0]->encrypt_id : ''}}">

                            </div>
                            <div  class="col-md-12 form-group no-padd ">
                                <label>Offer Price<span style="color: red;">*</span></label>
                                 <input type="text" class="form-control" id="variant_offer_price" placeholder="Offer Price" name="variant_offer_price" autocomplete="off" value="{{ !empty($product_single_variant_data_for_update[0]->variant_offer_price) ? $product_single_variant_data_for_update[0]->variant_offer_price : ''}}">

                            </div>
                          
                          <div class="clearfix"></div>
                            <div  class="col-md-12 form-group no-padd">
                                <label>Quantity<span style="color: red;">*</span></label>
                                 <input type="text" class="form-control" placeholder="Quantity" id="variant_quantity" name="variant_quantity" autocomplete="off" value="{{ !empty($product_single_variant_data_for_update[0]->variant_quantity) ? $product_single_variant_data_for_update[0]->variant_quantity : ''}}">

                            </div>

                            <div class="col-md-12 form-group no-padd">
                                <label>Unit<span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="variant_unit" placeholder="KG/Grm./Li..." name="variant_unit" autocomplete="off" value="{{ !empty($product_single_variant_data_for_update[0]->variant_unit) ? $product_single_variant_data_for_update[0]->variant_unit : '' }}">
                            </div>

                            <div  class="col-md-12 form-group no-padd">
                                <label>Stock<span style="color: red;">*</span></label>
                                 <input type="text" class="form-control" id="variant_stock" placeholder="Enter stock quantity in numbers" name="variant_stock" autocomplete="off" value="{{ !empty($product_single_variant_data_for_update[0]->variant_stock) ? $product_single_variant_data_for_update[0]->variant_stock : ''}}">

                            </div>
                           
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
                    <h1>Product Variant List </h1>

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
                                                      <th width="5%">Price</th>
                                                      <th width="5%">Offer Price</th>
                                                      <th width="5%">Quantity</th>
                                                      <th width="5%">Unit</th>
                                                      <th width="5%">Stock</th>
                                                      <th width="2%" >created at</th>
                                                      <th width="3%" >Action</th>
                                                   </tr>
                                             </thead>
                                            <tbody>
                                                @if(!empty($product_variant_data))
                                                     @php $x = 1;@endphp
                                                    @foreach($product_variant_data as $key => $value)
                                                <tr id="variant_row_{{ $x }}">
                                                    
                                                    <td>{{ $x }}</td>
                                                    <td>{{ $value['variant_price'] }}</td>
                                                    <td>{{ $value['variant_offer_price'] }}</td>
                                                    <td>{{ $value['variant_quantity'] }}</td>
                                                    <td>{{ $value['variant_unit'] }}</td>
                                                    <td>{{ $value['variant_stock'] }}</td>
                                                    <td>{{ date('d-m-Y h:i A',strtotime($value['created_at'])) }}</td>
                                                    <td><a href="{{ url('/edit-product-variant').'/'. $product_data[0]->id.'/'.Crypt::encryptString($value['id'])}}" class="edit btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>  <a href="javascript:void(0);" row-id="{{ $x }}" data-id="{{ Crypt::encryptString($value['id'])}} " class="btn btn-danger btn-xs delete-product-variant" flash="Product" table=" {{Crypt::encryptString('mangao_vendor_product_variant_list')}}" redirect-url="{{Crypt::encryptString('add-product-variant').'/'.$product_data[0]->id}}" title="Delete" ><i class="fa fa-trash"></i></a> </td>
                                                   
                                                </tr>
                                                 @php $x ++;@endphp
                                                    @endforeach
                                                    @endif
                                            </tbody>
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
     $(".ct_meun").removeClass("active");
    $(".products_active").addClass("active");
    $('#example').dataTable();
</script>


@endsection