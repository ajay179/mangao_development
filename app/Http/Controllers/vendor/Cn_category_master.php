<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DataTables;
use Illuminate\Support\Arr;
use App\Models\vendor\Md_vendor_category_master;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use DB;
use Config;
use Validator;

class Cn_category_master extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $class_name ="cn_vendor_category";
        return view('vendor.master.category',compact('class_name'));
    }


    /**
     * This are used to add banner Action .
     *
     * @return \Illuminate\Http\Response
     */
    public function vendorCategoryAction(Request $request)
    {
       $this->validate($request, [
           'vendor_category_name' => 'required'
        ]);
        
        // function used for add single array 
        $Md_vendor_category_master = new Md_vendor_category_master;
        if(!empty($request->txtpkey)){
            $msg = "updated";
            $txtpkey =  Crypt::decryptString($request->txtpkey);
            $data = Md_vendor_category_master::where('id', $txtpkey)->get();
            if($data->isEmpty()){
                return redirect()->route('vendor.category')->with('message', 'something went wrong');
            }else{
                $Md_vendor_category_master = Md_vendor_category_master::find($txtpkey);
                $Md_vendor_category_master->updated_at   = date('Y-m-d h:i:s');
                $Md_vendor_category_master->updated_by   = session()->get('*$%&%*id**$%#');
                $Md_vendor_category_master->updated_ip_address   = $request->ip();
            }
        }else{
            $msg = "Added";
            $Md_vendor_category_master->created_at   = date('Y-m-d h:i:s');
            $Md_vendor_category_master->created_by   = session()->get('*$%&%*id**$%#');
            $Md_vendor_category_master->created_ip_address   = $request->ip();
        }      
        $filename = '';
        if($request->has('vendor_category_image')){
            $filename = time().'_'.$request->file('vendor_category_image')->getClientOriginalName();
            $filePath = $request->file('vendor_category_image')->storeAs('public/vendor_category_image',$filename);  
        }else{
            $filePath = $request->vcategory_image_old;
        }
        $Md_vendor_category_master->vendor_category_name   = $request->vendor_category_name;
        $Md_vendor_category_master->vendor_category_image   = $filePath;
        $Md_vendor_category_master->category_type   = session()->get('$%vendor_category_type_id&%*');
        $Md_vendor_category_master->save();

        // this statement are used for getting the last inserted id
       //  $Md_mangao_banner->id;   

        return redirect()->route('vendor.category')->with('message', 'Category '. $msg);
    }
}
