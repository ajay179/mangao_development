@extends('vendor.layout.layout')
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

                    <h1>{{ !empty($product_data) ? 'Edit' : 'Add' }} Reataurant Product
                        <div class="pull-right">
                            <a href="{{ route('vendor.product') }}"><button type="button" class="btn btn-danger"><i class="fa fa-arrow-circle-left"></i> Back
                                </button></a>
                        </div>

                    </h1>
                </section>
                <section class="content" style="padding:5px 0px;">
                    <div class="box box-primary">
                        <div class="box-body light-green-body">
                            <form method='POST' id="vendorAddProductForm" enctype='multipart/form-data' action="{{ route('vendor.add.product.action')}}" >
                            @csrf  
                           <div class="col-md-8 no-pad-left">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Vendor Category<span style="color: red;">*</span></label>
                                        @php $vendor_category_id =  !empty($product_data[0]->vendor_category_id) ? $product_data[0]->vendor_category_id :  '' @endphp
                                        <select class="form-control" name="vendor_category_id" id="vendor_category_id">
                                            <option value="">Select Category</option>
                                            @if (!empty($get_vendor_category)) 
                                               @foreach ($get_vendor_category as $key => $value)
                                            <option value="{{ $value['id'] }}"  @if ($value->id == $vendor_category_id) selected @endif> {{ ucwords($value['vendor_category_name']) }}</option>
                                               @endforeach
                                            @endif
                                        </select>
                                        <input type="hidden" class="form-control" id="txtpkey" name="txtpkey" autocomplete="off" value="{{ !empty($product_data[0]->id) ? $product_data[0]->id : '' }}">
                                    </div>

                                   <div class="col-md-6 form-group">
                                        <label>Vendor Sub Category<span style="color: red;">*</span></label>
                                        @php $vendor_sub_category_id =  !empty($product_data[0]->vendor_sub_category_id) ? $product_data[0]->vendor_sub_category_id :  '' @endphp
                                        <select class="form-control" name="vendor_sub_category_id" id="vendor_sub_category_id">
                                            <option value="">Select Sub Category</option>
                                            @if (!empty($get_vendor_sub_category)) 
                                               @foreach ($get_vendor_sub_category as $key => $value)
                                            <option value="{{ $value['id'] }}"  @if ($value->id == $vendor_sub_category_id) selected @endif> {{ ucwords($value['vendor_sub_category_name']) }}</option>
                                               @endforeach
                                            @endif
                                        </select>
                                        
                                    </div>

                                    <div  class="col-md-6 form-group">
                                        <label>Product name<span style="color: red;">*</span></label>
                                         <input type="text" class="form-control" placeholder="Product name" id="product_name" name="product_name" autocomplete="off" value="{{ !empty($product_data[0]->product_name) ? $product_data[0]->product_name : ''}}">

                                    </div>
                                    <div  class="col-md-6 form-group">
                                        <label>Quantity<span style="color: red;">*</span></label>
                                         <input type="text" class="form-control" placeholder="Quantity" id="quantity" name="quantity" autocomplete="off" value="{{ !empty($product_data[0]->quantity) ? $product_data[0]->quantity : ''}}">

                                    </div>

                                    <div  class="col-md-6 form-group">
                                        <label>Price<span style="color: red;">*</span></label>
                                         <input type="text" class="form-control" placeholder="Price" id="price" name="price" autocomplete="off" value="{{ !empty($product_data[0]->price) ? $product_data[0]->price : ''}}">

                                    </div>
                                    <div  class="col-md-6 form-group ">
                                        <label>Offer Price<span style="color: red;">*</span></label>
                                         <input type="text" class="form-control" id="offer_price" placeholder="Offer Price" name="offer_price" autocomplete="off" value="{{ !empty($product_data[0]->offer_price) ? $product_data[0]->offer_price : ''}}">

                                    </div>
                                    
                                </div>
                            </div>

                            

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12 form-group no-pad">
                                        <div class="upload_img">
                                            <div class="upload_photo">
                                                <label>Image <small class="text-danger">(size:730*350)</small><span style="color: red;">*</span></label>
                                                <input type="file" name="product_image" accept=".jpg,.jpeg,.bmp,.png," id="product_image" onchange="change_img('product_image','image_preview')" class="form-control">
                                                <input type="hidden" name="product_image_old" id="product_image_old" value="{{ !empty($product_data[0]->product_image) ? $product_data[0]->product_image : '' }}" class="form-control">
                                            </div>
                                            <input type="hidden" class="form-control">

                                            <div class="img-preview">
                                                <div class="photo p-relative">
                                                    <img id="image_preview" name="image_preview" src="{{ !empty($product_data[0]->show_product_image) ? $product_data[0]->show_product_image : asset('commonarea/dist/img/default.png') }} " alt="image" style="height:100px; width:140px; margin-top:5px;object-fit: cover;" class="profile-img4">
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            
                            <div class="col-md-12 form-group no-pad-left ">
                                <label>product Description <span style="color: red;">*</span></label>
                                <textarea class="form-control" placeholder="Enter Description" name="product_description" autocomplete="off">{{ !empty($product_data[0]->product_description) ? $product_data[0]->product_description : ''}}</textarea>
                            </div>


                            <div class="clearfix"></div>

                            

                            <div class="col-md-12 no-pad-left">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Unit<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="unit" placeholder="KG/Grm./Li..." name="unit" autocomplete="off" value="{{ !empty($product_data[0]->unit) ? $product_data[0]->unit : '' }}">
                                    </div>

                                    <div  class="col-md-6 form-group no-pad-left">
                                        <label>Stock<span style="color: red;">*</span></label>
                                         <input type="text" class="form-control" id="stock" placeholder="Enter stock quantity in numbers" name="stock" autocomplete="off" value="{{ !empty($product_data[0]->stock) ? $product_data[0]->stock : ''}}">

                                    </div>
                                    
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            


                            <div class="col-md-12 form-group no-padd">

                                <button type="submit" class="btn btn-success save_btn submit" style="display:none;" data-id="submit" id="blogbtn"><i class="fa fa-check-circle"></i>
                                    {{ !empty($product_data[0]->id) ? 'Update' : 'Submit' }}</button>

                                <a href="{{ route('cityadmin.add.vendor')}}"> <button type="button" class="btn btn-danger"><i class="fa fa-times-circle"></i> Clear</button></a>
                            </div>
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
    $(".ct_meun").removeClass("active");
    $(".products_active").addClass("active");
  
    $('#blogbtn').show();
  
</script>

@endsection