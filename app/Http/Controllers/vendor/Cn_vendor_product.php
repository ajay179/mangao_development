<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Arr;
use App\Models\vendor\Md_vendor_product;
use App\Models\vendor\Md_vendor_category_master;
use App\Models\vendor\Md_sub_category_master;
use App\Models\vendor\Md_vendor_product_variant_list;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use DB;
use Config;

class Cn_vendor_product extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vendor.product.vw_product');
    }

    public function fun_add_product($value='')
    {
        $get_vendor_category = Md_vendor_category_master::latest()->where('status','<>',3)->where('vendor_id','=',session()->get('&&*id$##'))->where('category_type', '=', session()->get('$%vendor_category_type_id&%*'))->select('vendor_category_name','id')->get();
        
        $class_name = 'cn_vendor_product';
        return view('vendor.product.vw_add_product',compact('class_name','get_vendor_category'));
    }

    public function vendorAddProductAction(Request $request)
    {
        $price = $request->price;   
         $this->validate($request, [
            'vendor_category_id' => 'required|numeric','vendor_sub_category_id' => 'required|numeric','product_name' => 'required','quantity' => 'required|numeric','price' => 'required|numeric','offer_price' => 'required|numeric|max:'.$price,'product_description' => 'required','unit' => 'required','stock' => 'required'
        ]);
        
        $formdata = $request->all();
        $filename = '';
        if($request->has('product_image')){
            $filename = time().'_'.$request->file('product_image')->getClientOriginalName();
            $filePath = $request->file('product_image')->storeAs('public/product_image',$filename);  
        }else{
            $filePath = $request->product_image_old;
        }
               
        if(!empty($formdata['txtpkey'])){
            $msg = "updated";
            $txtpkey =  Crypt::decryptString($formdata['txtpkey']);
            $data = Md_vendor_product::where('id', $txtpkey)->get();
            if($data->isEmpty()){
                return redirect()->route('vendor.product')->with('message', 'something went wrong');
            }else{
                $formdata['product_image']   = $filePath;
                $formdata['updated_by']   = session()->get('&&*id$##');
                $formdata['category_type']   = session()->get('$%vendor_category_type_id&%*');
                $formdata['updated_ip_address']   = $request->ip();
                $formdata = Arr::except($formdata,['_token','txtpkey','product_image_old']);
                $Md_mangao_categories = Md_vendor_product::where('id',$txtpkey)->update($formdata);
            }
        }else{
            $msg = "Added";
            $formdata['product_image']   = $filePath;
            $formdata['created_by']   = session()->get('&&*id$##');
            $formdata['vendor_id']   = session()->get('&&*id$##');
            $formdata['category_type']   = session()->get('$%vendor_category_type_id&%*');
            $formdata['created_ip_address']   = $request->ip();
            $Md_mangao_categories = Md_vendor_product::create($formdata);
        }      
       
        return redirect()->route('vendor.product')->with('message', 'Product '. $msg);
    }

    public function get_sub_category_list_on_category_id(Request $request)
    {
        if ($request->ajax()) {
            try {
                $id =  $request->category_id;
                $category_data = Md_vendor_category_master::where('id','=', $id)
                    ->where('status', '<>', 3)
                    ->where('created_by','=',session()->get('&&*id$##'))
                    ->where('category_type', '=', session()->get('$%vendor_category_type_id&%*'))
                    ->get();

                if($category_data->isEmpty()){
                    $message = [
                        'message' =>  'Category Not Found.',
                        'status' => false,
                    ];
                    return response()->json($message);
                }else{
                    $sub_category_id = Md_sub_category_master::where('vendor_category_id','=', $id)->where('vendor_id','=',session()->get('&&*id$##'))->select('vendor_sub_category_name','id')
                    ->where('category_type', '=', session()->get('$%vendor_category_type_id&%*'))->get();
                    
                    $html ='<option value="">Select Sub Category </option>';
                    foreach ($sub_category_id as $key => $value) {
                        $html .= '<option value="'.$value['id'].'">'.$value['vendor_sub_category_name'].'</option>';
                    }

                    $message = [
                        'message' =>  "Sub category list found successfully.",
                        'status' => true,
                        'sub_category_list' => $html
                    ];
                    return response()->json($message);
                  
                }
            } catch (DecryptException $e) {
                return redirect('vendor-product')->with('error', 'something went wrong');
            }
        }else{
            exit('No direct script access allowed');
        }
    }



    public function get_data_table_of_vendor_product(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table(Config::get('constants.MANGAO_VENDOR_PRODUCT').'  as MVP')
            ->join(Config::get('constants.MANGAO_VENDOR_CATEGORY_MASTER').' as MVCM', 'MVCM.id', 'MVP.vendor_category_id')
            ->join(Config::get('constants.MANGAO_VENDOR_SUB_CATEGORY_MASTER').' as MVSCM', 'MVSCM.id', 'MVP.vendor_sub_category_id')
            ->where('MVP.status', '<>', 3)
            ->where('MVCM.status', '<>', 3)
            ->where('MVSCM.status', '<>', 3)
            ->where('MVP.category_type', '=', session()->get('$%vendor_category_type_id&%*'))
            ->where('MVP.vendor_id','=',session()->get('&&*id$##'))
            ->select('MVP.product_name','MVP.product_image','MVP.price','MVP.offer_price','MVP.status' ,'MVP.id', 'MVCM.vendor_category_name','MVP.created_at','MVSCM.vendor_sub_category_name')
            ->get();

            // return $data;

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn = '<a href="'. url("/edit-product") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record-of-vendor" flash="Product" table="' . Crypt::encryptString('mangao_vendor_product') . '" redirect-url="' . Crypt::encryptString('vendor-product') . '" title="Delete" ><i class="fa fa-trash"></i></a>  <a href="'. url("/add-product-variant") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-info btn-xs" style="margin-top:10px;"><i class="fa fa-plus"></i> Add variant</a> ';
                    return $btn;
                })
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })
                ->addColumn('product_image', function($data){
                    $url =Storage::url($data->product_image);
                    return $product_image = "<img src=".url($url)."  width='100%' />";
                })
                ->rawColumns(['date'])
                ->rawColumns(['action','product_image'])
                ->make(true);
        }
    }

    
    public function fun_edit_product($encrypt_id)
    {
        try {
            
            $id =  Crypt::decryptString($encrypt_id);
            $product_data =  DB::table(Config::get('constants.MANGAO_VENDOR_PRODUCT').'  as MVP')
            ->where('MVP.id', '=', $id)
            ->where('MVP.status', '<>', 3)
            ->where('MVP.category_type', '=', session()->get('$%vendor_category_type_id&%*'))
            ->where('MVP.vendor_id','=',session()->get('&&*id$##'))
            ->select('MVP.product_name','MVP.product_image','MVP.price','MVP.offer_price','MVP.status' ,'MVP.id', 'MVP.created_at','MVP.quantity','MVP.vendor_category_id','MVP.vendor_sub_category_id','MVP.product_description','MVP.unit','MVP.stock')
            ->get();


            $product_data[0]->id = Crypt::encryptString($product_data[0]->id);
            $class_name ='cn_vendor_product';
            
            //make image url
            $url =Storage::url($product_data[0]->product_image);
            $product_data[0]->show_product_image = url($url);

            $get_vendor_category = Md_vendor_category_master::latest()->where('status','<>',3)->where('vendor_id','=',session()->get('&&*id$##'))->where('category_type', '=', session()->get('$%vendor_category_type_id&%*'))->select('vendor_category_name','id')->get();

            if(!empty($product_data[0])){
                $get_vendor_sub_category = Md_sub_category_master::latest()->where('status','<>',3)->where('vendor_id','=',session()->get('&&*id$##'))
                ->where('category_type', '=', session()->get('$%vendor_category_type_id&%*'))
                ->where('vendor_category_id','=',$product_data[0]->vendor_category_id)
                ->select('vendor_sub_category_name','id')->get();

                return view('vendor.product.vw_add_product',compact('class_name','product_data','get_vendor_category','get_vendor_sub_category'));
            }else{
               return redirect('vendor-product')->with('error', 'something went wrong');
            }
        } catch (DecryptException $e) {
            return redirect('vendor-product')->with('error', 'something went wrong');
        }

    }


    public function fun_add_product_variant($encrypt_id)
    {
        try {
            
            $id =  Crypt::decryptString($encrypt_id);
            $product_data =  DB::table(Config::get('constants.MANGAO_VENDOR_PRODUCT').'  as MVP')
            ->where('MVP.id', '=', $id)
            ->where('MVP.status', '<>', 3)
            ->where('MVP.category_type', '=', session()->get('$%vendor_category_type_id&%*'))
            ->where('MVP.vendor_id','=',session()->get('&&*id$##'))
            ->select('MVP.product_name','MVP.product_image','MVP.price','MVP.offer_price','MVP.status' ,'MVP.id', 'MVP.created_at','MVP.quantity','MVP.vendor_category_id','MVP.vendor_sub_category_id','MVP.product_description','MVP.unit','MVP.stock')
            ->get();
            $product_data[0]->id = Crypt::encryptString($product_data[0]->id);
            
            $class_name ='cn_vendor_product';
            
            if(!empty($product_data[0])){
                $product_variant_data = Md_vendor_product_variant_list::where('product_id','=', $id)->where('status','=','1')->where('category_type', '=', session()->get('$%vendor_category_type_id&%*'))
            ->where('vendor_id','=',session()->get('&&*id$##'))->get();
                return view('vendor.product.vw_add_product_variant',compact('class_name','product_data','product_variant_data'));
            }else{
               return redirect('vendor-product')->with('error', 'something went wrong');
            }
        } catch (DecryptException $e) {
            return redirect('vendor-product')->with('error', 'something went wrong');
        }

    }

    public function fun_edit_product_variant($product_id ,$product_variant_id)
    {
        try {
            
            $id =  Crypt::decryptString($product_id);
            $product_variant_id =  Crypt::decryptString($product_variant_id);
            $product_data =  DB::table(Config::get('constants.MANGAO_VENDOR_PRODUCT').'  as MVP')
            ->where('MVP.id', '=', $id)
            ->where('MVP.status', '<>', 3)
            ->where('MVP.category_type', '=', session()->get('$%vendor_category_type_id&%*'))
            ->where('MVP.vendor_id','=',session()->get('&&*id$##'))
            ->select('MVP.product_name','MVP.product_image','MVP.price','MVP.offer_price','MVP.status' ,'MVP.id', 'MVP.created_at','MVP.quantity','MVP.vendor_category_id','MVP.vendor_sub_category_id','MVP.product_description','MVP.unit','MVP.stock')
            ->get();
            $product_data[0]->id = Crypt::encryptString($product_data[0]->id);
            
            $class_name ='cn_vendor_product';
            
            if(!empty($product_data[0])){
                $product_variant_data = Md_vendor_product_variant_list::where('product_id','=', $id)->where('status','=','1')->where('category_type', '=', session()->get('$%vendor_category_type_id&%*'))
            ->where('vendor_id','=',session()->get('&&*id$##'))->get();

            $product_single_variant_data_for_update = Md_vendor_product_variant_list::where('product_id','=', $id)
            ->where('id','=', $product_variant_id)
            ->where('status','=','1')->where('category_type', '=', session()->get('$%vendor_category_type_id&%*'))
            ->where('vendor_id','=',session()->get('&&*id$##'))->get();
            
            $product_single_variant_data_for_update[0]->encrypt_id = Crypt::encryptString($product_single_variant_data_for_update[0]->id);

            return view('vendor.product.vw_add_product_variant',compact('class_name','product_data','product_variant_data','product_single_variant_data_for_update'));
            }else{
               return redirect('vendor-product')->with('error', 'something went wrong');
            }
        } catch (DecryptException $e) {
            return redirect('vendor-product')->with('error', 'something went wrong');
        }
    }



    public function vendorAddProductVariantAction(Request $request)
    {
        $variant_price = $request->variant_price;   
         $this->validate($request, [
           'product_encrypt_id' => 'required','variant_quantity' => 'required|numeric','variant_price' => 'required|numeric','variant_offer_price' => 'required|numeric|max:'.$variant_price,'variant_unit' => 'required','variant_stock' => 'required'
        ]);
        
        $formdata = $request->all();
       
        $product_encrypt_id = $formdata['product_encrypt_id'];
        if(!empty($formdata['txtpkey'])){
            $msg = "updated";
            $txtpkey =  Crypt::decryptString($formdata['txtpkey']);
            $data = Md_vendor_product_variant_list::where('id', $txtpkey)->where('status','1')->get();
            if($data->isEmpty()){
                return redirect('add-product-variant/'.$product_encrypt_id)->with('message', 'something went wrong');
            }else{ 
                $formdata['updated_by']   = session()->get('&&*id$##');
                $formdata['category_type']   = session()->get('$%vendor_category_type_id&%*');
                $formdata['product_id']   = Crypt::decryptString($formdata['product_encrypt_id']);
                $formdata['vendor_id']   = session()->get('&&*id$##');
                $formdata['updated_ip_address']   = $request->ip();
                $formdata = Arr::except($formdata,['_token','txtpkey','product_encrypt_id','submit_btn']);
                $product_variant = Md_vendor_product_variant_list::where('id',$txtpkey)->update($formdata);
            }
        }else{
            $msg = "Added";
            $formdata['created_by']   = session()->get('&&*id$##');
            $formdata['product_id']   = Crypt::decryptString($formdata['product_encrypt_id']);
            $formdata['vendor_id']   = session()->get('&&*id$##');
            $formdata['category_type']   = session()->get('$%vendor_category_type_id&%*');
            $formdata['created_ip_address']   = $request->ip();
            $product_variant = Md_vendor_product_variant_list::create($formdata);
        }      
       
        return redirect('add-product-variant/'.$product_encrypt_id)->with('message', 'Product variant'. $msg);
 
    }

}
