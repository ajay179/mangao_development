<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\vendor\Md_vendor_category_master;
use App\Models\vendor\Md_sub_category_master;
use DataTables;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use DB;
use Config;
use Validator;

class Cn_sub_category_master extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $get_vendor_category = Md_vendor_category_master::latest()->where('status','<>',3)->where('vendor_id','=',session()->get('&&*id$##'))->where('category_type', '=', session()->get('$%vendor_category_type_id&%*'))->select('vendor_category_name','id')->get();
        $class_name = 'cn_vendor_category';
        return view('vendor.master.sub_category',compact('class_name','get_vendor_category'));
    }

    public function vendorSubCategoryAction(Request $request)
    {
        $this->validate($request, [
           'vendor_category_id' => 'required','vendor_sub_category_name' => 'required'
        ]);
        
        // function used for add single array 
        $Md_sub_category_master = new Md_sub_category_master;
        if(!empty($request->txtpkey)){
            $msg = "updated";
            $txtpkey =  Crypt::decryptString($request->txtpkey);
            $data = Md_sub_category_master::where('id', $txtpkey)->get();
            if($data->isEmpty()){
                return redirect()->route('vendor.category')->with('message', 'something went wrong');
            }else{
                $Md_sub_category_master = Md_sub_category_master::find($txtpkey);
                $Md_sub_category_master->updated_at   = date('Y-m-d h:i:s');
                $Md_sub_category_master->updated_by   = session()->get('&&*id$##');
                $Md_sub_category_master->updated_ip_address   = $request->ip();
            }
        }else{
            $msg = "Added";
            $Md_sub_category_master->created_at   = date('Y-m-d h:i:s');
            $Md_sub_category_master->created_by   = session()->get('&&*id$##');
            $Md_sub_category_master->vendor_id   = session()->get('&&*id$##');
            $Md_sub_category_master->created_ip_address   = $request->ip();
        }      
       
        $Md_sub_category_master->vendor_category_id   = $request->vendor_category_id;
        $Md_sub_category_master->vendor_sub_category_name   = $request->vendor_sub_category_name;
        $Md_sub_category_master->category_type   = session()->get('$%vendor_category_type_id&%*');
        $Md_sub_category_master->save();

        // this statement are used for getting the last inserted id
       //  $Md_mangao_banner->id;   

        return redirect()->route('vendor.sub.category')->with('message', 'Sub Category '. $msg);
    }

    public function get_data_table_of_vendor_sub_category(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table(Config::get('constants.MANGAO_VENDOR_SUB_CATEGORY_MASTER').'  as MVSCM')
            ->join(Config::get('constants.MANGAO_VENDOR_CATEGORY_MASTER').' as MVCM', 'MVCM.id', 'MVSCM.vendor_category_id')
            ->where('MVSCM.status', '<>', 3)
            ->where('MVCM.status', '<>', 3)
            ->where('MVSCM.category_type', '=', session()->get('$%vendor_category_type_id&%*'))
            ->where('MVSCM.vendor_id','=',session()->get('&&*id$##'))
            ->select('MVSCM.vendor_sub_category_name', 'MVSCM.id', 'MVCM.vendor_category_name','MVSCM.created_at')
            ->get();

            // return $data;

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn = '<a href="'. url("/edit-sub-vendor-category") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record-of-vendor" flash="Category admin" table="' . Crypt::encryptString('mangao_vendor_sub_category_master') . '" redirect-url="' . Crypt::encryptString('vendor-sub-category') . '" title="Delete" ><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })
                ->rawColumns(['date'])
                ->rawColumns(['action'])
                ->make(true);
        }

    }


    public function fun_edit_sub_vendor_category($encrypt_id)
    {
        try {
            
            $id =  Crypt::decryptString($encrypt_id);
            $vendor_sub_category_data = DB::table(Config::get('constants.MANGAO_VENDOR_SUB_CATEGORY_MASTER').'  as MVSCM')
            ->where('MVSCM.status', '<>', 3)->where('MVSCM.id', '=', $id)
            ->where('MVSCM.category_type', '=', session()->get('$%vendor_category_type_id&%*'))
            ->where('MVSCM.vendor_id','=',session()->get('&&*id$##'))
            ->select('MVSCM.vendor_sub_category_name','MVSCM.id','MVSCM.vendor_category_id')->get();

            $vendor_sub_category_data[0]->id = Crypt::encryptString($vendor_sub_category_data[0]->id);
            $class_name ='cn_vendor_category';
            
            $get_vendor_category = Md_vendor_category_master::latest()->where('status','<>',3)->where('vendor_id','=',session()->get('&&*id$##'))->where('category_type', '=', session()->get('$%vendor_category_type_id&%*'))->select('vendor_category_name','id')->get();
        
            if(!empty($vendor_sub_category_data[0])){
                return view('vendor.master.sub_category',compact('class_name','vendor_sub_category_data','get_vendor_category'));
            }else{
               return redirect('vendor-sub-category')->with('error', 'something went wrong');
            }
        } catch (DecryptException $e) {
            return redirect('vendor-sub-category')->with('error', 'something went wrong');
        }

    }


}
