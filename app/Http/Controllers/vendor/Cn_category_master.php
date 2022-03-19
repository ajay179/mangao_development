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
                $Md_vendor_category_master->updated_by   = session()->get('&&*id$##');
                $Md_vendor_category_master->updated_ip_address   = $request->ip();
            }
        }else{
            $msg = "Added";
            $Md_vendor_category_master->created_at   = date('Y-m-d h:i:s');
            $Md_vendor_category_master->created_by   = session()->get('&&*id$##');
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


    public function get_data_table_of_vendor_category(Request $request)
    {
        if ($request->ajax()) {
            $data = Md_vendor_category_master::latest()->select('vendor_category_name','vendor_category_image','id','created_at')->where('status', '<>', 3)->where('created_by','=',session()->get('&&*id$##'))->where('MVCM.category_type', '=', session()->get('$%vendor_category_type_id&%*'))->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn = '<a href="'. url("/edit-vendor-category") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record-of-vendor" flash="Category admin" table="' . Crypt::encryptString('mangao_vendor_category_master') . '" redirect-url="' . Crypt::encryptString('vendor-category') . '" title="Delete" ><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data['created_at']));
                    return $date_with_format;
                })
                ->addColumn('vendor_category_image', function($data){
                    $url =Storage::url($data['vendor_category_image']);
                    return $vendor_category_image = "<img src=".url($url)."  width='100%' />";
                })
                ->rawColumns(['date'])
                ->rawColumns(['action','vendor_category_image'])
                ->make(true);
        }

    }

    public function fun_edit_vendor_category($encrypt_id)
    {
        try {
            
            $id =  Crypt::decryptString($encrypt_id);
            $vendor_category_data = DB::table(Config::get('constants.MANGAO_VENDOR_CATEGORY_MASTER').'  as MVCM')->where('MVCM.status', '<>', 3)->where('MVCM.id', '=', $id)->where('MVCM.category_type', '=', session()->get('$%vendor_category_type_id&%*'))->where('MVCM.created_by','=',session()->get('&&*id$##'))->select('MVCM.vendor_category_name','MVCM.vendor_category_image','MVCM.id')->get();

            $vendor_category_data[0]->id = Crypt::encryptString($vendor_category_data[0]->id);
            $class_name ='cn_vendor_category';
            
            //make image url
            $url =Storage::url($vendor_category_data[0]->vendor_category_image);
            $vendor_category_data[0]->show_vendor_category_image = url($url);

            if(!empty($vendor_category_data[0])){
                return view('vendor.master.category',compact('class_name','vendor_category_data'));
            }else{
               return redirect('vendor-category')->with('error', 'something went wrong');
            }
        } catch (DecryptException $e) {
            return redirect('vendor-category')->with('error', 'something went wrong');
        }

    }


}
