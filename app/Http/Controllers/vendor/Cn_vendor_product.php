<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\vendor\Md_vendor_product;
use App\Models\vendor\Md_vendor_category_master;
use App\Models\vendor\Md_sub_category_master;
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
        $get_vendor_category = Md_vendor_category_master::latest()->where('status','<>',3)->where('created_by','=',session()->get('&&*id$##'))->where('category_type', '=', session()->get('$%vendor_category_type_id&%*'))->select('vendor_category_name','id')->get();
        
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
                return redirect()->route('main.categories')->with('message', 'something went wrong');
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
                    $sub_category_id = Md_sub_category_master::where('vendor_category_id','=', $id)->where('created_by','=',session()->get('&&*id$##'))->select('vendor_sub_category_name','id')
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
}
