<?php

namespace App\Http\Controllers\city_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\models\Md_mangao_categories;
use App\models\Md_city_admin_vendor;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use DB;
use Config;



class Cn_user_management extends Controller
{
    public function fun_vendor_list()
    {
        return view('city_admin.user_management.vw_vendor_list');
    }

    public function fun_add_vendor()
    {
        $class_name ='Cn_user_management';
        $vendor_data = Md_mangao_categories::latest()->where('status','<>',3)->select('category_name','id','created_at')->get();
        return view('city_admin.user_management.vw_add_vendor',compact('class_name','vendor_data'));
    }

    public function add_cityadmin_vendor()
    {
        $class_name ='Cn_user_management';
        $vendor_data = Md_mangao_categories::latest()->where('status','<>',3)->select('category_name','id','created_at')->get();
        return view('city_admin/user_management/vw_add_vendor',compact('class_name','vendor_data'));
    }

    /**
     * This are used to add city .
     *
     * @return \Illuminate\Http\Response
     */

    public function vendorCityAdminAction(Request $request)
    {
       $this->validate($request, [
            'category_id' => 'required','store_name' => 'required','store_owner_name' => 'required','vendor_latitude' => 'required','vendor_longitude' => 'required','vendor_comission' => 'required','vendor_address' => 'required','delivery_range' => 'required','vendor_email' => 'required','vendor_mobile_no' => 'required','vendor_password' => 'required'
        ]);
        
        // function used for add single array 
        $Md_city_admin_vendor = new Md_city_admin_vendor;

        $check_duplicate_vendor = Md_city_admin_vendor::where('vendor_email', $request->vendor_email);
        if(!empty($request->txtpkey)){
          $check_duplicate_vendor =  $check_duplicate_vendor->where('id','<>', Crypt::decryptString($request->txtpkey));
        }
        $check_duplicate_vendor = $check_duplicate_vendor->where('status','<>', 3)->get();
        if($check_duplicate_vendor->isNotEmpty()){
            return redirect()->route('cityadmin.view.vendor.list')->with('error', 'This city admin email already added.');
        }else{

            if(!empty($request->txtpkey)){
                $msg = "updated";
                $txtpkey =  Crypt::decryptString($request->txtpkey);
                $data = Md_city_admin_vendor::where('id', $txtpkey)->get();
                if($data->isEmpty()){
                    return redirect()->route('cityadmin.view.vendor.list')->with('message', 'something went wrong');
                }else{
                    $Md_city_admin_vendor = Md_city_admin_vendor::find($txtpkey);
                    $Md_city_admin_vendor->updated_at   = date('Y-m-d h:i:s');
                    $Md_city_admin_vendor->updated_by   = session()->get('*$%&%*id**$%#');
                    $Md_city_admin_vendor->updated_ip_address   = $request->ip();
                }
            }else{
                $msg = "Added";
                $Md_city_admin_vendor->created_at   = date('Y-m-d h:i:s');
                $Md_city_admin_vendor->created_by   = session()->get('*$%&%*id**$%#');
                $Md_city_admin_vendor->created_ip_address   = $request->ip();
            }      
            
            $Md_city_admin_vendor->category_id   = $request->category_id;
            $Md_city_admin_vendor->store_name   = $request->store_name;
            $Md_city_admin_vendor->store_owner_name   = $request->store_owner_name;
            $Md_city_admin_vendor->vendor_latitude   = $request->vendor_latitude;
            $Md_city_admin_vendor->vendor_longitude   = $request->vendor_longitude;
            $Md_city_admin_vendor->vendor_comission   = $request->vendor_comission;

            $Md_city_admin_vendor->vendor_address   = $request->vendor_address;
            $Md_city_admin_vendor->delivery_range   = $request->delivery_range;
            $Md_city_admin_vendor->vendor_email   = $request->vendor_email;
            $Md_city_admin_vendor->vendor_mobile_no   = $request->vendor_mobile_no;
            $Md_city_admin_vendor->vendor_password   = Hash::make($request->vendor_password);
            $Md_city_admin_vendor->encrypt_password   = Crypt::encryptString($request->vendor_password);
            $Md_city_admin_vendor->save();

            // this statement are used for getting the last inserted id
           //  $Md_city_master->id;   

            return redirect()->route('cityadmin.view.vendor.list')->with('message', 'Vendor'. $msg);
        }
    }

     public function get_data_table_of_city_admin_vendor(Request $request)
    {
        if ($request->ajax()) {
            $data = Md_city_admin_vendor::latest()->select('store_name','store_owner_name','vendor_address','vendor_email','vendor_mobile_no','id','created_at')->where('status', '<>', 3)->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn = '<a href="'. url("/cityadmin/edit-cityadmin-vendor") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record-of-city-admin" flash="Vendor" table="' . Crypt::encryptString('mangao_vendors') . '" redirect-url="' . Crypt::encryptString('cityadmin/view-vendor') . '" title="Delete" ><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data['created_at']));
                    return $date_with_format;
                })
               
                ->rawColumns(['date'])
                ->rawColumns(['action'])
                ->make(true);
        }

    }


    public function fun_edit_city_admin_vendor($encrypt_id)
    {
        try {
            
            $id =  Crypt::decryptString($encrypt_id);
            $vendor_info = DB::table(Config::get('constants.MANGAO_VENDORS').'  as MV')->where('MV.status', '<>', 3)->where('MV.id', '=', $id)->select('MV.category_id', 'MV.id','MV.store_name','MV.store_owner_name','MV.vendor_latitude','MV.vendor_longitude','MV.vendor_comission','MV.vendor_address','MV.delivery_range','MV.vendor_email','MV.vendor_mobile_no','vendor_password','MV.encrypt_password')->get();
            $vendor_data = Md_mangao_categories::latest()->where('status','<>',3)->select('category_name','id','created_at')->get();
            
            // Make id encrypt
            $vendor_info[0]->id = Crypt::encryptString($vendor_info[0]->id);
            
            //make image url
            // $url =Storage::url($vendor_info[0]->admin_img);
            // $vendor_info[0]->show_admin_img = url($url);
            
            //decrypt password
            $vendor_info[0]->encrypt_password = Crypt::decryptString($vendor_info[0]->encrypt_password);
            
            $class_name ='Cn_user_management';
           
            if(!empty($vendor_info[0])){
                return view('city_admin/user_management/vw_add_vendor',compact('class_name','vendor_info','vendor_data'));
            }else{
               return redirect('cityadmin.view.vendor.list')->with('error', 'something went wrong');
            }
        } catch (DecryptException $e) {
            return redirect('cityadmin.view.vendor.list')->with('error', 'something went wrong');
        }

    }



    public function fun_delivery_boy_list()
    {
        return view('city_admin.user_management.vw_delivery_boy_list');
    }

    public function fun_add_delivery_boy()
    {
        return view('city_admin.user_management.vw_add_delivery_boy');
    }


    
    
}
