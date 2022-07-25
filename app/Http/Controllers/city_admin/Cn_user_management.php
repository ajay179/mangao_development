<?php

namespace App\Http\Controllers\city_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Md_mangao_categories;
use App\Models\Md_city_admin_vendor;
use App\Models\Md_mangao_store_type_master;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;
use Config;



class Cn_user_management extends Controller
{
    public function fun_vendor_list()
    {
        Session::put([
            '&%*$^vendorusername$%#' => null,
            '&&*id$##' => null,
            '$%vendor_email&%*' => null,
            '$%vendor_category_type_id&%*' => null,
            '$%vendor_category_type&%*' => null,
            'city@dmin|ogin' => null,
            'city@dmin|oginTYpe' => null
        ]);
        Auth::guard('vendor')->logout();
        return view('city_admin.user_management.vw_vendor_list');
    }

    public function fun_add_vendor()
    {
        $class_name ='cn_user_management';
        $vendor_data = Md_mangao_categories::latest()->where('status','<>',3)->select('category_name','id','created_at')->get();
        $Store_type_list = Md_mangao_store_type_master::latest()->where('status','<>',3)->select('store_type_name','id')->get();
        
        return view('city_admin.user_management.vw_add_vendor',compact('class_name','vendor_data','Store_type_list'));
    }

    public function add_cityadmin_vendor()
    {
        $class_name ='cn_user_management';
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
            'category_id' => 'required','store_name' => 'required','store_owner_name' => 'required','vendor_latitude' => 'required','vendor_longitude' => 'required','vendor_comission' => 'required','vendor_address' => 'required','delivery_range' => 'required','vendor_email' => 'required','vendor_mobile_no' => 'required','password' => 'required'
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
                    $Md_city_admin_vendor->updated_by   = session()->get('&%*id$%#');
                    $Md_city_admin_vendor->updated_ip_address   = $request->ip();
                }
            }else{
                $msg = "Added";
                $Md_city_admin_vendor->created_at   = date('Y-m-d h:i:s');
                $Md_city_admin_vendor->created_by   = session()->get('&%*id$%#');
                $Md_city_admin_vendor->created_ip_address   = $request->ip();
            }      

             $filename = '';
            if($request->has('vendor_image')){
                $filename = time().'_'.$request->file('vendor_image')->getClientOriginalName();
                $filePath = $request->file('vendor_image')->storeAs('public/vendor_image',$filename);  
            }else{
                $filePath = $request->vendor_image_old;
            }
            
            $category_type = Md_mangao_categories::where('id','=',$request->category_id)->select('category_ui')->get();

            $Md_city_admin_vendor->vendor_city_id   = session()->get('$%#city_id&%*');
            $Md_city_admin_vendor->category_id   = $request->category_id;
            $Md_city_admin_vendor->store_name   = $request->store_name;
            $Md_city_admin_vendor->store_owner_name   = $request->store_owner_name;
            $Md_city_admin_vendor->vendor_latitude   = $request->vendor_latitude;
            $Md_city_admin_vendor->vendor_longitude   = $request->vendor_longitude;
            $Md_city_admin_vendor->vendor_comission   = $request->vendor_comission;
            $Md_city_admin_vendor->vendor_image   = $filePath;
            $Md_city_admin_vendor->category_type   = !empty($category_type[0]->category_ui) ? $category_type[0]->category_ui : 'other';
            
            $Md_city_admin_vendor->vendor_address   = $request->vendor_address;
            $Md_city_admin_vendor->delivery_range   = $request->delivery_range;
            $Md_city_admin_vendor->vendor_email   = $request->vendor_email;
            $Md_city_admin_vendor->vendor_mobile_no   = $request->vendor_mobile_no;
            $Md_city_admin_vendor->password   = Hash::make($request->password);
            $Md_city_admin_vendor->encrypt_password   = Crypt::encryptString($request->password);
            $Md_city_admin_vendor->save();

            // this statement are used for getting the last inserted id
           //  $Md_city_master->id;   

            return redirect()->route('cityadmin.view.vendor.list')->with('message', 'Vendor'. $msg);
        }
    }

    public function get_data_table_of_city_admin_vendor(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table(Config::get('constants.MANGAO_CITY_ADMIN_VENDOR').'  as MCAV')
                ->join(Config::get('constants.MANGAO_CITY_MASTER').' as MCM', 'MCM.id', 'MCAV.vendor_cITY_id')
                ->where('MCAV.status', '<>', 3)
                ->where('MCM.status', '<>', 3)
                ->where('MCAV.created_by', '=', session()->get('&%*id$%#'))
                ->select('MCAV.store_name','MCAV.store_owner_name','MCAV.vendor_address','MCAV.vendor_email','MCAV.vendor_mobile_no','MCAV.id','MCAV.created_at','MCM.city_name','MCAV.status')
                ->get();


            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn = '<a href="'. url("/cityadmin/edit-cityadmin-vendor") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record-of-city-admin" flash="Vendor" table="' . Crypt::encryptString('mangao_vendors') . '" alert_status="'.$data->status.'" redirect-url="' . Crypt::encryptString('cityadmin/view-vendor') . '" title="Delete" ><i class="fa fa-trash"></i></a><br>

                        <a href="'. url("/vendor-secret-login-by-cityadmin") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-primary btn-xs"><i class="fa fa-sign-in"></i> login</a>
                    ';
                    return $btn;
                })

                ->addColumn('status', function($data){
                    $status_class = (!empty($data->status)) && ($data->status == 1) ? 'tgle-on' : 'tgle-off'; 
                    $status = '<a href="javascript:void(0);" flash="Vendor" status="'.Crypt::encryptString($data->status).'" table="' . Crypt::encryptString('mangao_vendors') . '" alert_status="'.$data->status.'"  data-id="' . Crypt::encryptString($data->id) . '"  class="cityadmin-change-vendor-status"  > <i class="fa fa-toggle-on '. $status_class.' " aria-hidden="true" title="Active"></i></a>';
                    return $status;
                })
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })
                ->addColumn('wallet_amount', '0')
                ->addColumn('total_amount_settled', '0')
                ->addColumn('total_order_completed', '0')
                ->addColumn('rating', '0')
                // ->addColumn('status', 'pending')
                ->rawColumns(['date'])
                ->rawColumns(['action','status'])
                ->make(true);
        }

    }


    public function fun_edit_city_admin_vendor($encrypt_id)
    {
        try {
            
            $id =  Crypt::decryptString($encrypt_id);
            $vendor_info = DB::table(Config::get('constants.MANGAO_VENDORS').'  as MV')->where('MV.status', '<>', 3)->where('MV.id', '=', $id)->select('MV.category_id', 'MV.id','MV.store_name','MV.store_owner_name','MV.vendor_latitude','MV.vendor_longitude','MV.vendor_comission','MV.vendor_address','MV.delivery_range','MV.vendor_email','MV.vendor_mobile_no','MV.password','MV.encrypt_password','MV.vendor_image')->get();
            $vendor_data = Md_mangao_categories::latest()->where('status','<>',3)->select('category_name','id','created_at')->get();
            
            // Make id encrypt
            $vendor_info[0]->id = Crypt::encryptString($vendor_info[0]->id);
            
            // make image url
            $url =Storage::url($vendor_info[0]->vendor_image);
            $vendor_info[0]->show_vendor_img = url($url);
            
            //decrypt password
            $vendor_info[0]->encrypt_password = Crypt::decryptString($vendor_info[0]->encrypt_password);
            

            // return $vendor_info;

            $class_name ='cn_user_management';
           
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


    public function fun_secret_login_by_cityadmin($encrypt_id)
    {
        try {
            
            $id =  Crypt::decryptString($encrypt_id);
            $vendor_data = DB::table(Config::get('constants.MANGAO_VENDORS').'  as MV')->where('MV.status', '<>', 3)->where('MV.id', '=', $id)->select('MV.store_name', 'MV.id','MV.category_id','MV.vendor_email','MV.encrypt_password','MV.category_type')->get();
            
            if(!empty($vendor_data[0])){
                $admin_data = array(
                    'vendor_email' =>$vendor_data[0]->vendor_email,
                    'password' => Crypt::decryptString($vendor_data[0]->encrypt_password)
                );
                if(Auth::guard('vendor')->attempt($admin_data)){
                    // Session::flush();
                    Session::put([
                        '&%*$^vendorusername$%#' => Auth::guard('vendor')->user()->store_name,
                        '&&*id$##' => Auth::guard('vendor')->user()->id,
                        '$%vendor_email&%*' => Auth::guard('vendor')->user()->vendor_email,
                        '$%vendor_category_type_id&%*' => Auth::guard('vendor')->user()->category_id,
                        '$%vendor_category_type&%*' => Auth::guard('vendor')->user()->category_type,
                        'city@dmin|ogin' => '^&*548$%',
                        'city@dmin|oginTYpe' => 'vendor'
                    ]);
                    
                    if (Session::has('&%*$^vendorusername$%#', '&&*id$##', '$%vendor_email&%*')) {
                        return redirect('vendor-dashbord')->with('message', 'Successfully Logged In!');
                    } else {
                        return redirect('view-all-vendor')->with('error', 'You have entered wrong credentials.. Please try again...');
                    }
                
                }else{
                    return redirect('view-all-vendor')->with('error', 'You have entered wrong password.. Please try again...');
                }
            }else{
               return redirect('view-all-vendor')->with('error', 'something went wrong');
            }
        } catch (DecryptException $e) {
            return redirect('view-all-vendor')->with('error', 'something went wrong');
        }

    }

    
}
